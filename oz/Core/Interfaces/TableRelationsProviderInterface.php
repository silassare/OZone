<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone (O'Zone) package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OZONE\OZ\Core\Interfaces;

interface TableRelationsProviderInterface
{
	/**
	 * Returns custom relations definition.
	 *
	 * ```php
	 * [
	 *    'table_name' => [
	 *         'relation_1' => callable,
	 *            ...
	 *         'relation_n' => callable
	 *     ],
	 *      ...
	 * ]
	 * ```
	 *
	 * @return array
	 */
	public static function getRelationsDefinition();
}
