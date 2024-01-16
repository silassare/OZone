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

namespace OZONE\Core\Migrations\Events;

use Gobl\DBAL\Interfaces\MigrationInterface;
use PHPUtils\Events\Event;

/**
 * Class MigrationAfterRun.
 *
 * This event is triggered just after a migration is executed.
 */
final class MigrationAfterRun extends Event
{
	/**
	 * MigrationAfterRun constructor.
	 *
	 * @param MigrationInterface $migration the migration instance
	 * @param bool               $rollback  true if the we are rolling back
	 */
	public function __construct(
		public readonly MigrationInterface $migration,
		public readonly bool $rollback
	) {}
}