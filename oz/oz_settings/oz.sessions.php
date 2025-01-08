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

return [
	/**
	 * Session cookie name.
	 */
	'OZ_SESSION_COOKIE_NAME'                 => 'OZONE_SID',

	/**
	 * Max session life time in seconds.
	 *
	 * Default: 30 days
	 */
	'OZ_SESSION_LIFE_TIME'                   => 3600 * 24 * 30, // 30 days

	/**
	 * Enable/Disable same source session hijacking protection.
	 */
	'OZ_SESSION_HIJACKING_FORCE_SAME_SOURCE' => 1,
];
