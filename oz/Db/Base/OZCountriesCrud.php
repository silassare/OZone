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
 * Class OZCountriesCrud.
 *
 * @extends \Gobl\CRUD\CRUDEventProducer<\OZONE\Core\Db\OZCountry>
 */
abstract class OZCountriesCrud extends \Gobl\CRUD\CRUDEventProducer
{
	/**
	 * OZCountriesCrud constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			\OZONE\Core\Db\OZCountry::TABLE_NAMESPACE,
			\OZONE\Core\Db\OZCountry::TABLE_NAME
		);
	}
}