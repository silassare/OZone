<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OZONE\Core\Users\Events;

use OZONE\Core\App\Context;
use PHPUtils\Events\Event;

/**
 * Class UserLogInUnknown.
 */
final class UserLogInUnknown extends Event
{
	public function __construct(private Context $context)
	{
	}

	/**
	 * @return \OZONE\Core\App\Context
	 */
	public function getContext(): Context
	{
		return $this->context;
	}
}
