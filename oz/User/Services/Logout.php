<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of OZone (O'Zone) package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace OZONE\OZ\User\Services;

	use OZONE\OZ\Core\BaseService;
	use OZONE\OZ\User\UsersUtils;

	defined('OZ_SELF_SECURITY_CHECK') or die;

	/**
	 * Class Logout
	 *
	 * @package OZONE\OZ\User\Services
	 */
	final class Logout extends BaseService
	{
		/**
		 * {@inheritdoc}
		 * @throws \Exception
		 */
		public function execute(array $request = [])
		{
			UsersUtils::logUserOut();
			$this->getResponseHolder()->setDone('OZ_USER_LOGOUT');
		}
	}