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

namespace OZONE\Core\Forms;

use Gobl\DBAL\Types\Exceptions\TypesException;
use Gobl\DBAL\Types\Type;
use Gobl\DBAL\Types\TypeDate;
use OZONE\Core\Exceptions\RuntimeException;

/**
 * Class Fields.
 */
class Fields
{
	/**
	 * Returns a birth date field.
	 *
	 * @param int $min_age
	 * @param int $max_age
	 *
	 * @return \Gobl\DBAL\Types\Type
	 */
	public static function birthDate(int $min_age, int $max_age): Type
	{
		try {
			$min_date = \sprintf('%s-01-01', \date('Y') - $max_age);
			$max_date = \sprintf('%s-12-31', \date('Y') - $min_age);
			$type     = new TypeDate();

			return $type->min($min_date)
				->max($max_date)
				->format('Y-m-d');
		} catch (TypesException $e) {
			throw new RuntimeException(null, null, $e);
		}
	}
}
