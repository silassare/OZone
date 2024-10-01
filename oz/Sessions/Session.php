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

namespace OZONE\Core\Sessions;

use OZONE\Core\App\Context;
use OZONE\Core\App\Keys;
use OZONE\Core\App\Settings;
use OZONE\Core\Cache\CacheManager;
use OZONE\Core\Db\OZSession;
use OZONE\Core\Db\OZSessionsQuery;
use OZONE\Core\Db\OZUser;
use OZONE\Core\Exceptions\RuntimeException;
use OZONE\Core\Hooks\Events\DbReadyHook;
use OZONE\Core\Hooks\Events\FinishHook;
use OZONE\Core\Hooks\Events\ResponseHook;
use OZONE\Core\Hooks\Interfaces\BootHookReceiverInterface;
use OZONE\Core\Http\Cookie;
use OZONE\Core\Http\Cookies;
use OZONE\Core\OZone;
use OZONE\Core\Utils\Random;
use PHPUtils\Events\Event;
use Throwable;

/**
 * Class Session.
 */
final class Session implements BootHookReceiverInterface
{
	private const SESSION_ID_REG = '~^[-,a-zA-Z0-9]{32,128}$~';

	private ?SessionState $state = null;

	private ?OZSession $sess_entry = null;

	private bool $started = false;

	private bool $delete_cookie = false;

	/**
	 * Session constructor.
	 *
	 * @param Context $context
	 * @param string  $request_source_key
	 */
	public function __construct(protected Context $context, private readonly string $request_source_key) {}

	/**
	 * Session destructor.
	 */
	public function __destruct()
	{
		unset($this->context, $this->state, $this->sess_entry);
	}

	/**
	 * Returns session lifetime in seconds from settings.
	 *
	 * @return int
	 */
	public static function lifetime(): int
	{
		return (int) Settings::get('oz.sessions', 'OZ_SESSION_LIFE_TIME');
	}

	/**
	 * Returns session cookie name from setting.
	 */
	public static function cookieName(): string
	{
		return Settings::get('oz.sessions', 'OZ_SESSION_COOKIE_NAME');
	}

	/**
	 * Returns session attached user ID.
	 */
	public function attachedUserID(): ?string
	{
		$this->assertSessionStarted();

		return $this->sess_entry->getUserID();
	}

	/**
	 * Returns session ID.
	 *
	 * @return string
	 */
	public function id(): string
	{
		$this->assertSessionStarted();

		return $this->sess_entry->getID();
	}

	/**
	 * Returns session source key.
	 *
	 * @return string
	 */
	public function sourceKey(): string
	{
		return $this->request_source_key;
	}

	/**
	 * To checks if session is started.
	 *
	 * @return bool
	 */
	public function isStarted(): bool
	{
		return $this->started;
	}

	/**
	 * Start the session.
	 *
	 * @return $this
	 */
	public function start(?string $session_id = null): self
	{
		if ($session_id) {
			$this->sess_entry = self::findSessionByID($session_id);
		}

		if (!$this->sess_entry) {
			$sid = Keys::newSessionID();

			$this->sess_entry = new OZSession();
			$this->sess_entry->setID($sid)
				->setRequestSourceKey($this->request_source_key);
		}

		$this->state         = SessionState::getInstance($this->sess_entry);
		$this->started       = true;
		$this->delete_cookie = false;

		return $this;
	}

	/**
	 * Restart the session.
	 *
	 * @return $this
	 */
	public function restart(): self
	{
		$this->assertSessionStarted();

		return $this->destroy()
			->start();
	}

	/**
	 * Destroy the session.
	 *
	 * @return $this
	 */
	public function destroy(): self
	{
		$this->assertSessionStarted();

		if (!$this->sess_entry->isNew()) {
			self::delete($this->sess_entry->getID());
		}

		$this->sess_entry    = null;
		$this->state         = null;
		$this->started       = false;
		$this->delete_cookie = true;

		return $this;
	}

	/**
	 * Attach user to this session.
	 *
	 * @param OZUser $user
	 *
	 * @return $this
	 */
	public function attachUser(OZUser $user): self
	{
		$this->assertSessionStarted();

		// it may be a new session, so we save first
		$uid              = $user->getID();
		$sid              = $this->sess_entry->getID();
		$session_owner_id = $this->sess_entry->getUserID();

		if ($session_owner_id && $uid !== $session_owner_id) {
			throw new RuntimeException('OZ_SESSION_DISTINCT_USER_CANT_ATTACH_USER', [
				'user_id'     => $uid,
				'_session_id' => $sid,
				'_owner'      => [
					'session_owner_id' => $session_owner_id,
				],
			]);
		}

		$this->sess_entry->setUserID($uid);

		return $this;
	}

	/**
	 * Gets the session data store.
	 *
	 * @return SessionState
	 */
	public function state(): SessionState
	{
		$this->assertSessionStarted();

		return $this->state;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function boot(): void
	{
		ResponseHook::listen(static function (ResponseHook $ev) {
			$context = $ev->context;
			if ($context->hasSession()) {
				$context->session()
					->responseReady();
			}
		}, Event::RUN_LAST);

		FinishHook::listen(static function () {
			self::gc();
		}, Event::RUN_LAST);

		if (\class_exists(OZSession::class)) {
			DbReadyHook::listen(static function () {
				OZSession::crud()
					->onBeforePKColumnWrite(static fn () => true);
			});
		}
	}

	/**
	 * Find session by ID.
	 *
	 * @param string $sid
	 *
	 * @return null|OZSession
	 */
	public static function findSessionByID(string $sid): ?OZSession
	{
		if (!OZone::hasDbInstalled() || !self::isSessionIdLike($sid)) {
			return null;
		}

		$factory = static function () use ($sid) {
			try {
				$sqb = new OZSessionsQuery();

				$result = $sqb->whereIdIs($sid)
					->whereIsValid()
					->find(1);

				$item = $result->fetchClass();

				if ($item && $item->getExpire() > \time()) {
					return $item;
				}
			} catch (Throwable $t) {
				throw new RuntimeException('Unable to load session with session ID.', ['_session_id' => $sid], $t);
			}

			return null;
		};

		return CacheManager::runtime(__METHOD__)
			->factory($sid, $factory)
			->get();
	}

	/**
	 * Response ready hook.
	 */
	private function responseReady(): void
	{
		$response            = $this->context->getResponse();
		$session_cookie_name = self::cookieName();

		/** @var null|Cookie $cookie */
		$cookie = null;

		if ($this->started) {
			$this->save();
			$cookie          = Cookie::create($this->context, $session_cookie_name, $this->sess_entry->getID());
			$cookie->expires = \time() + self::lifetime();
		}

		if ($this->delete_cookie) {
			$cookie = Cookie::create($this->context, $session_cookie_name)->drop();
		}

		if ($cookie) {
			$cookies_jar = new Cookies();
			$cookies_jar->add(Cookie::create($this->context, $session_cookie_name)->drop());
			$response = $response->withHeader('Set-Cookie', $cookies_jar->toResponseHeaders());
		}

		$this->context->setResponse($response);
	}

	/**
	 * Assert if the session started.
	 */
	private function assertSessionStarted(): void
	{
		if (!$this->started || !isset($this->sess_entry, $this->state)) {
			throw new RuntimeException('Session not yet started.');
		}
	}

	/**
	 * Save session data.
	 */
	private function save(): void
	{
		if (!OZone::hasDbInstalled()) {
			return;
		}
		$sid = $this->sess_entry->getID();

		try {
			$now    = \time();
			$expire = $now + self::lifetime();

			$data = $this->state->getData();

			$this->sess_entry->setData($data)
				->setExpire($expire)
				->setLastSeen($now)
				->setUpdatedAT($now)
				->save();
		} catch (Throwable $t) {
			throw new RuntimeException('Unable to save session.', ['_session_id' => $sid], $t);
		}
	}

	/**
	 * Delete all expired sessions.
	 */
	private static function gc(): void
	{
		if (Random::bool() && OZone::hasDbInstalled()) {
			try {
				$s_table = new OZSessionsQuery();
				$s_table->whereExpireIsLte(\time())
					->delete()
					->execute();
			} catch (Throwable $t) {
				throw new RuntimeException('Unable to delete expired session.', null, $t);
			}
		}
	}

	/**
	 * Checks for session id string.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	private static function isSessionIdLike(mixed $value): bool
	{
		return \is_string($value) && \preg_match(self::SESSION_ID_REG, $value);
	}

	/**
	 * Delete session from database.
	 *
	 * @param string $sid
	 */
	private static function delete(string $sid): void
	{
		if (!OZone::hasDbInstalled()) {
			return;
		}

		try {
			$s_table = new OZSessionsQuery();

			$s_table->whereIdIs($sid)
				->delete()
				->execute();
		} catch (Throwable $t) {
			throw new RuntimeException('OZ_SESSION_DELETION_FAILED', ['_session_id' => $sid], $t);
		}
	}
}
