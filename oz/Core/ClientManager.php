<?php
	/**
	 * Copyright (c) 2017-present, Emile Silas Sare
	 *
	 * This file is part of OZone (O'Zone) package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace OZONE\OZ\Core;

	use Exception;
	use OZONE\OZ\Db\OZClientsQuery;
	use OZONE\OZ\Db\OZSessionsQuery;
	use OZONE\OZ\Exceptions\InternalErrorException;

	defined('OZ_SELF_SECURITY_CHECK') or die;

	class ClientManager
	{
		/**
		 * Gets client instance with a given api key
		 *
		 * @param string $api_key The client api key
		 *
		 * @return null|\OZONE\OZ\Db\OZClient
		 * @throws \OZONE\OZ\Exceptions\InternalErrorException
		 */
		public static function getClientWithApiKey($api_key)
		{
			try {
				$c = new OZClientsQuery();

				return $c->filterByApiKey($api_key)
						 ->find(1)
						 ->fetchClass();
			} catch (Exception $e) {
				throw new InternalErrorException("Unable to get client with API key.", [
					"api_key" => $api_key
				], $e);
			}
		}

		/**
		 * Gets client instance with a given session id
		 *
		 * @param string $sid The session id
		 *
		 * @return null|\OZONE\OZ\Db\OZClient
		 * @throws \OZONE\OZ\Exceptions\InternalErrorException
		 */
		public static function getClientWithSessionId($sid)
		{
			try {
				$sc = new OZSessionsQuery();

				$session = $sc->filterById($sid)
							  ->find(1)
							  ->fetchClass();

				if ($session) {
					return $session->getOZClient();
				}
			} catch (Exception $e) {
				throw new InternalErrorException("Unable to get client with session id.", ["sid" => $sid], $e);
			}

			return null;
		}

		/**
		 * Gets client instance with a given token
		 *
		 * @param string $token The token
		 *
		 * @return null|\OZONE\OZ\Db\OZClient
		 * @throws \OZONE\OZ\Exceptions\InternalErrorException
		 */
		public static function getClientWithSessionToken($token)
		{
			try {
				$sc      = new OZSessionsQuery();
				$session = $sc->filterByToken($token)
							  ->find(1)
							  ->fetchClass();

				if ($session) {
					return $session->getOZClient();
				}
			} catch (Exception $e) {
				throw new InternalErrorException("Unable to get client with session token.", ["token" => $token], $e);
			}

			return null;
		}
	}
