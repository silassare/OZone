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

namespace OZONE\OZ\Db\Base;

/**
 * Class OZUsersController.
 *
 * @method \OZONE\OZ\Db\OZUser      addItem(array|\OZONE\OZ\Db\OZUser $item = [])
 * @method null|\OZONE\OZ\Db\OZUser getItem(array $filters, array $order_by = [])
 * @method null|\OZONE\OZ\Db\OZUser deleteOneItem(array $filters)
 * @method \OZONE\OZ\Db\OZUser[]    getAllItems(array $filters = [], int $max = null, int $offset = 0, array $order_by = [], ?int &$total = -1)
 * @method \OZONE\OZ\Db\OZUser[]    getAllItemsCustom(\Gobl\DBAL\Queries\QBSelect $qb, int $max = null, int $offset = 0, &$total = false)
 * @method null|\OZONE\OZ\Db\OZUser updateOneItem(array $filters, array $new_values)
 */
abstract class OZUsersController extends \Gobl\ORM\ORMController
{
	/**
	 * OZUsersController constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			\OZONE\OZ\Db\OZUser::TABLE_NAMESPACE,
			\OZONE\OZ\Db\OZUser::TABLE_NAME
		);
	}
}
