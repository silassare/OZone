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

/**
 * Class OZCountryVR.
 *
 * @template TRelationResult
 *
 * @extends \Gobl\DBAL\Relations\VirtualRelation<\OZONE\Core\Db\OZCountry, TRelationResult>
 */
abstract class OZCountryVR extends \Gobl\DBAL\Relations\VirtualRelation
{
	/**
	 * {class_name} constructor.
	 *
	 * @param string $name      the relation name
	 * @param bool   $paginated true if the relation returns paginated items
	 */
	public function __construct(string $name, bool $paginated)
	{
		parent::__construct(
			\OZONE\Core\Db\OZCountry::TABLE_NAMESPACE,
			\OZONE\Core\Db\OZCountry::TABLE_NAME,
			$name,
			$paginated
		);
	}
}
