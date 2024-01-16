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

namespace OZONE\Core\Queue\Hooks;

use OZONE\Core\Queue\Interfaces\JobContractInterface;
use PHPUtils\Events\Event;

/**
 * Class JobBeforeStart.
 *
 * This event is triggered when a job is about to start.
 */
final class JobBeforeStart extends Event
{
	/**
	 * JobBeforeStart constructor.
	 *
	 * @param JobContractInterface $contract the job contract
	 */
	public function __construct(public readonly JobContractInterface $contract) {}
}
