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
use Gobl\DBAL\Relations\Relation;
use Gobl\ORM\ORMEntity;

/**
 * Class OZSessionsController.
 *
 * @method \OZONE\Core\Db\OZSession      addItem(array|\OZONE\Core\Db\OZSession $item = [])
 * @method null|\OZONE\Core\Db\OZSession getItem(array $filters, array $order_by = [])
 * @method null|\OZONE\Core\Db\OZSession deleteOneItem(array $filters)
 * @method \OZONE\Core\Db\OZSession[]    getAllItems(array $filters = [], int $max = null, int $offset = 0, array $order_by = [], ?int &$total = null)
 * @method \OZONE\Core\Db\OZSession[]    getAllItemsCustom(QBSelect $qb, int $max = null, int $offset = 0, ?int &$total = null)
 * @method \OZONE\Core\Db\OZSession      getRelative(ORMEntity $entity, Relation $relation, array $filters = [], array $order_by = [])
 * @method \OZONE\Core\Db\OZSession[]    getAllRelatives(ORMEntity $entity, Relation $relation, array $filters = [], int $max = null, int $offset = 0, array $order_by = [], ?int &$total = null)
 * @method null|\OZONE\Core\Db\OZSession updateOneItem(array $filters, array $new_values)
 */
abstract class OZSessionsController extends \Gobl\ORM\ORMController
{
	/**
	 * OZSessionsController constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			\OZONE\Core\Db\OZSession::TABLE_NAMESPACE,
			\OZONE\Core\Db\OZSession::TABLE_NAME
		);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return static
	 */
	public static function createInstance(): static
	{
		return new \OZONE\Core\Db\OZSessionsController();
	}
}
