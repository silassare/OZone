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

namespace OZONE\Core\Db\Base;

use Gobl\DBAL\Queries\QBSelect;
use Gobl\ORM\ORMResults;
use OZONE\Core\Db\OZJob;
use OZONE\Core\Db\OZJobsResults as OZJobsResultsReal;

/**
 * Class OZJobsResults.
 *
 * @extends \Gobl\ORM\ORMResults<\OZONE\Core\Db\OZJob>
 */
abstract class OZJobsResults extends ORMResults
{
	/**
	 * OZJobsResults constructor.
	 */
	public function __construct(QBSelect $query)
	{
		parent::__construct(
			OZJob::TABLE_NAMESPACE,
			OZJob::TABLE_NAME,
			$query
		);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return static
	 */
	public static function new(QBSelect $query): static
	{
		return new OZJobsResultsReal($query);
	}
}
