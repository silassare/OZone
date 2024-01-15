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
use OZONE\Core\Db\OZUser;
use PHPUtils\Events\Event;

/**
 * Class UserLoggedOut.
 */
final class UserLoggedOut extends Event
{
	public function __construct(private readonly Context $context, private readonly OZUser $user) {}

	/**
	 * @return Context
	 */
	public function getContext(): Context
	{
		return $this->context;
	}

	/**
	 * @return OZUser
	 */
	public function getUser(): OZUser
	{
		return $this->user;
	}
}
