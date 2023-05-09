<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace OZONE\OZ\Router;

use Gobl\DBAL\Types\TypeString;
use OZONE\OZ\Auth\Auth;
use OZONE\OZ\Auth\AuthScope;
use OZONE\OZ\Auth\AuthState;
use OZONE\OZ\Auth\Providers\AuthEmail;
use OZONE\OZ\Auth\Providers\AuthPhone;
use OZONE\OZ\Columns\Types\TypeEmail;
use OZONE\OZ\Columns\Types\TypePassword;
use OZONE\OZ\Columns\Types\TypePhone;
use OZONE\OZ\Core\Context;
use OZONE\OZ\Core\Hasher;
use OZONE\OZ\Core\JSONResponse;
use OZONE\OZ\Crypt\DoCrypt;
use OZONE\OZ\Db\OZAuth;
use OZONE\OZ\Db\OZClient;
use OZONE\OZ\Db\OZUser;
use OZONE\OZ\Exceptions\ForbiddenException;
use OZONE\OZ\Exceptions\UnauthorizedActionException;
use OZONE\OZ\Forms\Form;
use OZONE\OZ\Forms\FormData;
use OZONE\OZ\Router\Interfaces\RouteGuardInterface;
use OZONE\OZ\Router\Views\AccessGrantView;
use OZONE\OZ\Users\UserRole;
use PHPUtils\Store\Store;
use PHPUtils\Traits\ArrayCapableTrait;

/**
 * Class RouteGuard.
 */
class RouteGuard implements RouteGuardInterface
{
	use ArrayCapableTrait;

	protected const USER     = 'user';
	protected const PASSWORD = 'password';

	protected array $clean = [];

	/**
	 * @var \PHPUtils\Store\Store<array>
	 */
	protected Store    $rules;
	protected FormData $auth_fd;

	/**
	 * RouteGuard constructor.
	 *
	 * @param \OZONE\OZ\Core\Context $context
	 * @param array                  $rules
	 */
	public function __construct(protected Context $context, array $rules = [])
	{
		$this->rules   = new Store($rules);
		$this->auth_fd = new FormData();
	}

	/**
	 * RouteGuard destructor.
	 */
	public function __destruct()
	{
		unset($this->context, $this->rules);
	}

	/**
	 * @param string $password
	 * @param bool   $hash_password
	 *
	 * @return $this
	 */
	public function withPassword(string $password, bool $hash_password = true): self
	{
		if ($hash_password) {
			$crypt    = new DoCrypt();
			$password = $crypt->passHash($password);
		}

		$this->rules->set('password_protected', [
			'password_hash' => $password,
		]);

		return $this;
	}

	/**
	 * @param null|string $user
	 * @param null|string $password
	 * @param bool        $hash_password
	 *
	 * @return $this
	 */
	public function withLogin(
		?string $user = null,
		?string $password = null,
		bool $hash_password = true
	): self {
		$data = [];

		if (!empty($user)) {
			$data['user'] = $user;
		}

		if (!empty($password)) {
			if ($hash_password) {
				$crypt    = new DoCrypt();
				$password = $crypt->passHash($password);
			}

			$data['password_hash'] = $password;
		}

		$this->rules->set('login', $data);

		return $this;
	}

	/**
	 * @param null|string $user
	 * @param null|string $password
	 * @param bool        $hash_password
	 * @param string      $realm
	 *
	 * @return $this
	 */
	public function withBasicAuth(
		?string $user = null,
		?string $password = null,
		bool $hash_password = true,
		string $realm = 'OZ_AUTHENTICATION_REQUIRED'
	): self {
		$data = [
			'type'  => HTTPAuthType::BASIC->value,
			'realm' => $realm,
		];

		if (!empty($user)) {
			$data['user'] = $user;
		}

		if (!empty($password)) {
			if ($hash_password) {
				$crypt    = new DoCrypt();
				$password = $crypt->passHash($password);
			}

			$data['password_hash'] = $password;
		}

		$this->rules->set('http_auth', $data);

		return $this;
	}

	/**
	 * @param string $user
	 * @param string $password
	 * @param bool   $rfc2617
	 * @param string $realm
	 *
	 * @return $this
	 */
	public function withDigestAuth(
		string $user,
		string $password,
		bool $rfc2617 = true,
		string $realm = 'OZ_AUTHENTICATION_REQUIRED'
	): self {
		$this->rules->set('http_auth', [
			'type'         => ($rfc2617 ? HTTPAuthType::DIGEST_RFC_2617 : HTTPAuthType::DIGEST)->value,
			'realm'        => $realm,
			'user'         => $user,
			'password_md5' => \md5($password),
		]);

		return $this;
	}

	/**
	 * @param string $token
	 * @param string $realm
	 *
	 * @return $this
	 */
	public function withBearerAuth(string $token, string $realm = 'OZ_AUTHENTICATION_REQUIRED'): self
	{
		$this->rules->set('http_auth', [
			'type'  => HTTPAuthType::BEARER->value,
			'realm' => $realm,
			'token' => $token,
		]);

		return $this;
	}

	/**
	 * @param string[] $allowed_providers_name
	 *
	 * @return $this
	 */
	public function with2FA(string ...$allowed_providers_name): static
	{
		$this->rules->set('2fa', [
			'providers' => empty($allowed_providers_name) ? [
				AuthPhone::NAME,
				AuthEmail::NAME,
			] : $allowed_providers_name,
		]);

		return $this;
	}

	/**
	 * @param \OZONE\OZ\Db\OZClient $client
	 *
	 * @return $this
	 */
	public function allowClient(OZClient $client): self
	{
		$key = \sprintf('clients_allowed.%s', $client->getID());
		$this->rules->set($key, 1);

		return $this;
	}

	/**
	 * @param \OZONE\OZ\Db\OZClient $client
	 *
	 * @return $this
	 */
	public function notClient(OZClient $client): self
	{
		$key = \sprintf('clients_not_allowed.%s', $client->getID());
		$this->rules->set($key, 1);

		return $this;
	}

	/**
	 * @param \OZONE\OZ\Users\UserRole|string $role
	 *
	 * @return $this
	 */
	public function withRole(string|UserRole $role): self
	{
		$key = \sprintf('roles_allowed.%s', $role);
		$this->rules->set($key, 1);

		return $this;
	}

	/**
	 * @return $this
	 */
	public function verifiedUsersOnly(): self
	{
		$this->rules->set('verified_users_only', 1);

		return $this;
	}

	/**
	 * @param \OZONE\OZ\Db\OZUser $user
	 *
	 * @return $this
	 */
	public function allowUser(OZUser $user): self
	{
		$key = \sprintf('users_allowed.%s', $user->getID());

		$this->rules->set($key, 1);

		return $this;
	}

	/**
	 * @param \OZONE\OZ\Db\OZUser $user
	 *
	 * @return $this
	 */
	public function notUser(OZUser $user): self
	{
		$key = \sprintf('users_not_allowed.%s', $user->getID());

		$this->rules->set($key, 1);

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getAuthData(): FormData
	{
		return $this->auth_fd;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 * @throws \OZONE\OZ\Exceptions\InvalidFormException
	 * @throws \OZONE\OZ\Exceptions\UnauthorizedActionException
	 * @throws \OZONE\OZ\Exceptions\UnverifiedUserException
	 * @throws \OZONE\OZ\Exceptions\NotFoundException
	 */
	public function checkAccess(): void
	{
		$session = $this->context->getSession();

		if (!$session->isStarted()) {
			$session->start();
		}

		$client = $session->getClient();

		if ($this->rules->has(\sprintf('clients_not_allowed.%s', $client->getID()))) {
			throw new ForbiddenException(null, [
				'_reason' => 'Request client is in not allowed list.',
			]);
		}

		if ($this->rules->has('clients_allowed') && !$this->rules->has(\sprintf('clients_allowed.%s', $client->getID()))) {
			throw new ForbiddenException(null, [
				'_reason' => 'Request client not in allowed list.',
			]);
		}

		$um = $this->context->getUsersManager();

		if ($this->rules->has('verified_users_only')) {
			$um->assertUserVerified();
		}

		if ($this->rules->has('users_not_allowed')) {
			$um->assertUserVerified();

			if ($this->rules->has(\sprintf('users_not_allowed.%s', $um->getCurrentUserID()))) {
				throw new ForbiddenException(null, [
					'_reason' => 'User is in not allowed list.',
				]);
			}
		}

		if ($this->rules->has('users_allowed')) {
			$um->assertUserVerified();

			if (!$this->rules->has(\sprintf('users_allowed.%s', $um->getCurrentUserID()))) {
				throw new ForbiddenException(null, [
					'_reason' => 'User not in allowed list.',
				]);
			}
		}

		if ($this->rules->has('roles_allowed')) {
			$um->assertUserVerified();

			$roles = $this->rules->get('roles_allowed');
			$roles = \array_keys($roles);

			if (!$um::hasOneRoleAtLeast($um->getCurrentUserID(), $roles, /* we need to be strict */ false)) {
				throw new ForbiddenException(null, [
					'_reason' => 'User role is not in allowed list.',
				]);
			}
		}

		if ($this->rules->has('http_auth')) {
			$this->requireHTTPAuth();
		}

		if ($this->rules->has('2fa')) {
			$this->require2FA();
		}

		if ($this->rules->has('login')) {
			$this->requireLogin();
		}

		if ($this->rules->has('password_protected')) {
			$this->requirePassword();
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function toArray(): array
	{
		return $this->rules->getData();
	}

	/**
	 * This will require a successful auth ref.
	 *
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 * @throws \OZONE\OZ\Exceptions\UnauthorizedActionException
	 * @throws \OZONE\OZ\Exceptions\NotFoundException
	 */
	protected function require2FA(): void
	{
		$allowed_providers = $this->rules->get('2fa.providers');
		$auth_ref          = $this->context->getRequest()
			->getUnsafeFormField(OZAuth::COL_REF);

		$auth = Auth::getRequiredByRef($auth_ref);

		if (!\in_array($auth->provider, $allowed_providers, true)) {
			throw new ForbiddenException('OZ_2FA_PROVIDER_NOT_ALLOWED', [
				// don't reveal the provider to attacker,
				// it's like sending the attacker in the right direction
				'_allowed_2fa' => $allowed_providers,
				'_provider'    => $auth->provider,
			]);
		}

		$provider = Auth::getAuthProvider($auth->provider, $this->context, AuthScope::from($auth));

		if (AuthState::AUTHORIZED !== $provider->getState()) {
			throw new UnauthorizedActionException();
		}

		$this->auth_fd->set('2fa', $auth);
	}

	/**
	 * This will show a password form.
	 *
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 * @throws \OZONE\OZ\Exceptions\InvalidFormException
	 * @throws \OZONE\OZ\Exceptions\UnauthorizedActionException
	 */
	protected function requirePassword(): void
	{
		$form = new Form();
		$form->field(self::PASSWORD)
			->type(new TypePassword())
			->required();

		$fd = $this->requireForm($form);

		$known_password_hash = $this->rules->get('password_protected.password_hash');
		$req_password        = $fd->get(self::PASSWORD);
		$crypt               = new DoCrypt();

		if (!$crypt->passCheck($req_password, $known_password_hash)) {
			// invalid password
			throw new ForbiddenException();
		}

		$this->auth_fd->merge($fd);
	}

	/**
	 * This will show a login form.
	 *
	 * @throws \OZONE\OZ\Exceptions\UnauthorizedActionException
	 * @throws \OZONE\OZ\Exceptions\InvalidFormException
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 */
	protected function requireLogin(): void
	{
		$user_type = $this->rules->get('login.user_type');

		if ('email' === $user_type) {
			$type = new TypeEmail();
		} elseif ('phone' === $user_type) {
			$type = new TypePhone();
		} else {
			$type = (new TypeString())->oneLine();
		}

		$form = new Form();
		$form->field(self::USER)
			->type($type)
			->required();
		$form->field(self::PASSWORD)
			->type(new TypePassword())
			->required();

		$clean_form = $this->requireForm($form);

		$req_user     = $clean_form->get(self::USER);
		$req_password = $clean_form->get(self::PASSWORD);

		if ($this->rules->has('login.user')) {
			$user = $this->rules->get('login.user');

			if ($req_user !== $user) {
				// invalid user
				throw new ForbiddenException();
			}
		}

		if ($this->rules->has('login.password_hash')) {
			$known_password_hash = $this->rules->get('login.password_hash');
			$crypt               = new DoCrypt();

			if (!$crypt->passCheck($req_password, $known_password_hash)) {
				// invalid password
				throw new ForbiddenException();
			}
		}

		$this->auth_fd->set('login.user', $req_user)
			->set('login.password', $req_password);
	}

	/**
	 * This will show a custom form,
	 * and makes sure the form is submitted and is valid.
	 *
	 * @throws \OZONE\OZ\Exceptions\UnauthorizedActionException
	 * @throws \OZONE\OZ\Exceptions\InvalidFormException
	 */
	protected function requireForm(Form $form): FormData
	{
		$request = $this->context->getRequest();
		$s       = $this->context->getSession()
			->getDataStore();
		$uri     = $this->context->getRequest()
			->getUri();

		$reference  = Hasher::hash32((string) $uri);
		$form_key   = \sprintf('route_guard.clean_forms.%s', $reference);
		$clean_form = $s->get($form_key);

		if (\is_array($clean_form)) {
			return new FormData($clean_form);
		}

		$req_grant_ref = $request->getUnsafeFormField('grant_form_ref');

		if ($req_grant_ref === $reference) {
			$clean_form = $form->validate($request->getUnsafeFormData());

			$s->set($form_key, $clean_form);

			return $clean_form;
		}

		$form->setSubmitTo($uri);
		$form->field('grant_form_ref')
			->type((new TypeString())->default($reference))
			->required();

		$exception = new UnauthorizedActionException();

		if ($this->context->shouldReturnJSON()) {
			$json = new JSONResponse();

			$json->setError($exception->getMessage())
				->setForm($form);

			$response = $this->context->getResponse()
				->withJson($json);
		} else {
			$view     = new AccessGrantView($this->context);
			$response = $view->renderAccessGrantForm($form);
		}

		throw $exception->setCustomResponse($response);
	}

	/**
	 * This makes sure client/user provide http auth credentials.
	 *
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 * @throws \OZONE\OZ\Exceptions\UnauthorizedActionException
	 */
	protected function requireHTTPAuth(): void
	{
		$request = $this->context->getRequest();

		$realm = $this->rules->get('http_auth.realm');
		$type  = $this->rules->get('http_auth.type');

		if (!empty($request->getHeaderLine('Authorization'))) {
			switch (HTTPAuthType::from($type)) {
				case HTTPAuthType::BASIC:
					$this->handleBasicAuth();

					return;

				case HTTPAuthType::BEARER:
					$this->handleBearerAuth();

					return;

				case HTTPAuthType::DIGEST:
				case HTTPAuthType::DIGEST_RFC_2617:
					$this->handleDigestAuth();

					return;
			}
		}

		$data         = [];
		$header_value = '';

		switch ($type) {
			case HTTPAuthType::BEARER:
			case HTTPAuthType::BASIC:
				$header_value = \sprintf('%s realm="%s"', $type->value, $realm);

				break;

			case HTTPAuthType::DIGEST:
				$data['realm'] = $realm;
				$nonce         = $data['nonce'] = Hasher::hash32();
				$opaque        = $data['opaque'] = Hasher::hash32($realm);
				$header_value  = \sprintf('Digest realm="%s",nonce="%s",opaque="%s"', $realm, $nonce, $opaque);

				break;

			case HTTPAuthType::DIGEST_RFC_2617:
				$data['realm'] = $realm;
				$nonce         = $data['nonce'] = Hasher::hash32();
				$opaque        = $data['opaque'] = Hasher::hash32($realm);
				$header_value  = \sprintf('Digest realm="%s",qop="auth",nonce="%s",opaque="%s"', $realm, $nonce, $opaque);

				break;
		}

		$exception = new UnauthorizedActionException();

		if ($this->context->shouldReturnJSON()) {
			$json = new JSONResponse();

			$json->setError($exception->getMessage())
				->setData($data);

			$response = $this->context->getResponse()
				->withJson($json);
		} else {
			$view     = new AccessGrantView($this->context);
			$response = $view->renderAccessGrantAuth($realm);
		}

		throw $exception->setCustomResponse($response->withHeader('WWW-Authenticate', $header_value));
	}

	/**
	 * Handle basic auth request.
	 *
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 */
	protected function handleBasicAuth(): void
	{
		$env          = $this->context->getEnv();
		$req_user     = $env->get('PHP_AUTH_USER');
		$req_password = $env->get('PHP_AUTH_PW');

		if (empty($req_user) || empty($req_password)) {
			// no user and/or password
			throw new ForbiddenException();
		}

		if ($this->rules->has('http_auth.user')) {
			$user = $this->rules->get('http_auth.user');

			if ($req_user !== $user) {
				// invalid user
				throw new ForbiddenException();
			}
		}

		if ($this->rules->has('http_auth.password_hash')) {
			$known_password_hash = $this->rules->get('http_auth.password_hash');
			$crypt               = new DoCrypt();

			if (!$crypt->passCheck($req_password, $known_password_hash)) {
				// invalid password
				throw new ForbiddenException();
			}
		}

		$this->auth_fd->set('http_auth.user', $req_user)
			->set('http_auth.password', $req_password);
	}

	/**
	 * Handle bearer auth request.
	 *
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 */
	protected function handleBearerAuth(): void
	{
		$header = $this->context->getRequest()
			->getHeaderLine('HTTP_AUTHORIZATION');

		if (empty($header) || !\preg_match('~Bearer\s(\S+)~', $header, $matches)) {
			// invalid token
			throw new ForbiddenException();
		}

		$req_token = $matches[1];

		if ($this->rules->has('http_auth.token')) {
			$known_token = $this->rules->get('http_auth.token');

			if ($req_token !== $known_token) {
				// invalid token
				throw new ForbiddenException();
			}
		}

		$this->auth_fd->set('http_auth.token', $req_token);
	}

	/**
	 * Handle digest auth request.
	 *
	 * @throws \OZONE\OZ\Exceptions\ForbiddenException
	 */
	protected function handleDigestAuth(): void
	{
		$request    = $this->context->getRequest();
		$env        = $this->context->getEnv();
		$req_digest = $env->get('PHP_AUTH_DIGEST');
		$req_method = $request->getMethod();
		$realm      = $this->rules->get('http_auth.realm');
		$rfc2617    = $this->rules->get('http_auth.type') === HTTPAuthType::DIGEST_RFC_2617->value;

		if (empty($req_digest)) {
			// no user and/or password
			throw new ForbiddenException();
		}

		$required_parts = [
			'nonce',
			'username',
			'uri',
			'response',
		];

		if ($rfc2617) {
			$required_parts[] = 'nc';
			$required_parts[] = 'cnonce';
			$required_parts[] = 'qop';
		}

		$parsed = self::parseDigestAuth($req_digest, $required_parts);

		if (!$parsed) {
			// invalid digest
			throw new ForbiddenException();
		}

		$known_user = $this->rules->get('http_auth.user');
		$known_pass = $this->rules->get('http_auth.password_md5');

		$A1 = \md5($known_user . ':' . $realm . ':' . $known_pass);
		$A2 = \md5($req_method . ':' . $parsed['uri']);

		if ($rfc2617) {
			$valid_response = \md5($A1 . ':' . $parsed['nonce'] . ':' . $parsed['nc'] . ':' . $parsed['cnonce'] . ':' . $parsed['qop'] . ':' . $A2);
		} else {
			$valid_response = \md5($A1 . ':' . $parsed['nonce'] . ':' . $A2);
		}

		if ($valid_response !== $parsed['response']) {
			// invalid digest response
			throw new ForbiddenException();
		}

		$this->auth_fd->set('http_auth', $parsed);
	}

	/**
	 * Parse digest auth header string.
	 *
	 * @param string $digest
	 * @param array  $required_parts
	 *
	 * @return array|false
	 */
	protected static function parseDigestAuth(string $digest, array $required_parts): bool|array
	{
		$data           = [];
		$keys           = \implode('|', $required_parts);
		$required_parts = \array_fill_keys($required_parts, 1);

		\preg_match_all('~(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))~', $digest, $matches, \PREG_SET_ORDER);

		foreach ($matches as $m) {
			$data[$m[1]] = $m[3] ?: $m[4];
			unset($required_parts[$m[1]]);
		}

		return $required_parts ? false : $data;
	}
}