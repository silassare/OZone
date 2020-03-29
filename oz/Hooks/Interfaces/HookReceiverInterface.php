<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone (O'Zone) package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OZONE\OZ\Hooks\Interfaces;

\defined('OZ_SELF_SECURITY_CHECK') || die;

interface HookReceiverInterface
{
	/**
	 * Called to ask the hook receiver to register itself.
	 */
	public static function register();
}