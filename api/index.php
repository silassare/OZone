<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use OZONE\OZ\Loader\ClassLoader;
use OZONE\OZ\OZone;
use SAMPLE\App\SampleApp;

// =	Don't forget to use DS instead of \ or / and
// = always add the last DS to your directories path
if (!\defined('DS')) {
	\define('DS', \DIRECTORY_SEPARATOR);
}

// = Project directory
// = any relative path will be resolved using this path as starting point
if (!\defined('OZ_PROJECT_DIR')) {
	\define('OZ_PROJECT_DIR', \dirname(__DIR__) . DS);
}

// = You can define the path to your ozone app directory here
if (!\defined('OZ_APP_DIR')) {
	\define('OZ_APP_DIR', __DIR__ . DS . 'app' . DS);
}

// = Files directory
if (!\defined('OZ_FILES_DIR')) {
	\define('OZ_FILES_DIR', OZ_APP_DIR . 'oz_users_files' . DS);
}

// = Cache directory
if (!\defined('OZ_CACHE_DIR')) {
	\define('OZ_CACHE_DIR', OZ_APP_DIR . 'oz_cache' . DS);
}

// = Logs directory
if (!\defined('OZ_LOG_DIR')) {
	\define('OZ_LOG_DIR', __DIR__ . DS);
}

// = Load composer autoload
require_once OZ_PROJECT_DIR . 'vendor' . DS . 'autoload.php';

// = Adds project namespace root directory
ClassLoader::addNamespace('\SAMPLE\App', OZ_APP_DIR);

// = Run the app if we are not in web context
if (!\defined('OZ_OZONE_IS_WEB_CONTEXT')) {
	OZone::run(new SampleApp());
}
