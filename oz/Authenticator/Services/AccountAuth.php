<?php
	/**
	 * Copyright (c) 2017-present, Emile Silas Sare
	 *
	 * This file is part of OZone (O'Zone) package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace OZONE\OZ\Authenticator\Services;

	use Gobl\DBAL\Rule;
	use OZONE\OZ\Core\Context;
	use OZONE\OZ\Core\Assert;
	use OZONE\OZ\Core\BaseService;
	use OZONE\OZ\Core\Session;
	use OZONE\OZ\Core\SessionDataStore;
	use OZONE\OZ\Db\OZSessionsQuery;
	use OZONE\OZ\Db\OZUsersQuery;
	use OZONE\OZ\Exceptions\ForbiddenException;
	use OZONE\OZ\Router\RouteInfo;
	use OZONE\OZ\Router\Router;

	defined('OZ_SELF_SECURITY_CHECK') or die;

	/**
	 * Class AccountAuth
	 *
	 * @package OZONE\OZ\User\Services
	 */
	final class AccountAuth extends BaseService
	{
		/**
		 * @param \OZONE\OZ\Core\Context $context
		 *
		 * @throws \OZONE\OZ\Exceptions\UnverifiedUserException
		 */
		public function actionCreate(Context $context)
		{
			$users_manager = $context->getUsersManager();

			$users_manager->assertUserVerified();

			$client = $context->getClient();
			$data   = [
				'api_key' => $client->getApiKey(),
				'token'   => $users_manager->getCurrentSessionToken(),
				'uid'     => $users_manager->getCurrentUserId()
			];

			$this->getResponseHolder()
				 ->setDone()
				 ->setData([
					 'account' => self::encode($data)
				 ]);
		}

		/**
		 * @param \OZONE\OZ\Core\Context $context
		 * @param string                 $account
		 *
		 * @throws \Exception
		 */
		public function actionCheck(Context $context, $account)
		{
			// And yes! user sent us a form
			// so we check that the form is valid.
			$context->getUsersManager()
					->logUserOut();

			$data = self::decode($account);

			Assert::assertForm($data, [
				'token',
				'api_key',
				'uid'
			], new ForbiddenException('OZ_ERROR_INVALID_ACCOUNT_AUTH'));

			$verified = false;
			$user     = null;
			$api_key  = $data['api_key'];
			$token    = $data['token'];
			$uid      = $data['uid'];

			$sq      = new OZSessionsQuery();
			$session = $sq->filterByClientApiKey($api_key)
						  ->filterByToken($token)
						  ->filterByUserId($uid)
						  ->filterByExpire(time(), Rule::OP_GT)
						  ->find(1)
						  ->fetchClass();

			$uq = new OZUsersQuery();

			if ($session AND $user = $uq->filterById($uid)
										->find(1)
										->fetchClass()) {
				$decoded = Session::decode($session->getData());

				if (is_array($decoded)) {
					$data_store = new SessionDataStore($decoded);
					$verified   = $data_store->get('ozone_user:verified');
				}
			}

			if (!$verified) {
				throw new ForbiddenException('OZ_ERROR_INVALID_ACCOUNT_AUTH');
			}

			$context->getUsersManager()
					->logUserIn($user);

			$this->getResponseHolder()
				 ->setDone('OZ_USER_ONLINE')
				 ->setData($user->asArray());
		}

		/**
		 * @param array $data
		 *
		 * @return string
		 */
		private static function encode(array $data)
		{
			return base64_encode(json_encode($data));
		}

		/**
		 * @param $str
		 *
		 * @return array|false
		 */
		private static function decode($str)
		{
			$data = false;

			try {
				$data = json_decode(base64_decode($str), true);
			} catch (\Exception $e) {
			}

			return $data;
		}

		/**
		 * {@inheritdoc}
		 */
		public static function registerRoutes(Router $router)
		{
			$router->get('/account-auth', function (RouteInfo $r) {
				$context  = $r->getContext();
				$account  = $context->getRequest()
									->getFormField('account', null);
				$instance = new AccountAuth($context);

				if (!is_null($account)) {
					$instance->actionCheck($context, $account);
				} else {
					$instance->actionCreate($context);
				}

				return $instance->writeResponse($context);
			});
		}
	}