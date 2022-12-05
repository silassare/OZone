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

namespace OZONE\OZ\Users\Services;

use OZONE\OZ\Core\Service;
use OZONE\OZ\Db\OZUser;
use OZONE\OZ\Exceptions\InvalidFormException;
use OZONE\OZ\Router\RouteInfo;
use OZONE\OZ\Router\Router;
use OZONE\OZ\Users\UsersManager;

/**
 * Class Login.
 */
final class Login extends Service
{
	public const ROUTE_LOGIN = 'oz:login';

	/**
	 * @throws \OZONE\OZ\Exceptions\InvalidFormException
	 */
	public function actionLogin(): void
	{
		$context       = $this->getContext();
		$users_manager = $context->getUsersManager();
		// And yes! user sent us a form
		// so we check that the form is valid.
		$users_manager->logUserOut();

		$form = $context->getRequest()
			->getUnsafeFormData();

		if (isset($form['phone'])) {
			$result = $users_manager->tryPhoneLogIn($context, $form);
		} elseif (isset($form['email'])) {
			$result = $users_manager->tryEmailLogIn($context, $form);
		} else {
			throw new InvalidFormException();
		}

		if ($result instanceof OZUser) {
			$this->getJSONResponse()
				->setDone('OZ_USER_ONLINE')
				->setData($result);
		} else {
			$this->getJSONResponse()
				->setError($result);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public static function registerRoutes(Router $router): void
	{
		$router->post('/login', function (RouteInfo $ri) {
			$s       = new self($ri);
			$s->actionLogin();

			return $s->respond();
		})->name(self::ROUTE_LOGIN)
			->form(UsersManager::logOnForm(...));
	}
}
