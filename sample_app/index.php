<?php
	/**
	 * Copyright (c) Silas E. Sare <emile.silas@gmail.com>
	 *
	 * This file is part of the OZone package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	//SILO:: Protect from unauthorized access/include
	define( 'OZ_SELF_SECURITY_CHECK', 1 );

	//NOTICE: don't forget to use DS instead of \ or / and allways add the last DS to your directories path

	define( 'DS', DIRECTORY_SEPARATOR );
	define( 'OZ_ROOT_DIR', __DIR__ . DS );

	//SILO:: You can define the path to your ozone app directory here
	define( 'OZ_APP_DIR', OZ_ROOT_DIR . 'app' . DS );

	include_once OZ_ROOT_DIR . 'oz' . DS . 'OZone.php';

	\OZONE\OZ\Loader\ClassLoader::addNamespace( '\OZONE\App', OZ_APP_DIR );
	\OZONE\OZ\OZone::execute( new \OZONE\App\SampleApp() );