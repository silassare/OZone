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
use OZONE\OZ\Router\RouteInfo;
use OZONE\OZ\Router\Router;

/**
 * Class Logout.
 */
final class Logout extends Service
{
	public const ROUTE_LOGOUT = 'oz:logout';

	public function actionLogout(): void
	{
		$this->getContext()->getUsersManager()->logUserOut();

		$this->getJSONResponse()
			->setDone('OZ_USER_LOGOUT');
	}

	/**
	 * {@inheritDoc}
	 */
	public static function registerRoutes(Router $router): void
	{
		$router->post('/logout', function (RouteInfo $ri) {
			$s       = new self($ri);
			$s->actionLogout();

			return $s->respond();
		})->name(self::ROUTE_LOGOUT);
	}
}