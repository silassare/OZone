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

use Gobl\DBAL\Operator;

/**
 * Class OZUsersQuery.
 *
 * @method \OZONE\Core\Db\OZUsersResults find(?int $max = null, int $offset = 0, array $order_by = [])
 */
abstract class OZUsersQuery extends \Gobl\ORM\ORMTableQuery
{
	/**
	 * OZUsersQuery constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			\OZONE\Core\Db\OZUser::TABLE_NAMESPACE,
			\OZONE\Core\Db\OZUser::TABLE_NAME
		);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return static
	 */
	public static function createInstance(): static
	{
		return new \OZONE\Core\Db\OZUsersQuery();
	}

	/**
	 * {@inheritDoc}
	 */
	public function subGroup(): static
	{
		$instance              = new static();
		$instance->qb          = $this->qb;
		$instance->filters     = $this->filters->subGroup();
		$instance->table_alias = $this->table_alias;

		return $instance;
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`id`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIs(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`id`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsNot(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`id`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsLt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`id`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsLte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`id`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsGt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`id`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsGte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`id`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`id`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`id`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`id`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereIdIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_ID,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIs(string $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsNot(string $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsLt(string $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsLte(string $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsGt(string $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsGte(string $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`phone`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `is_null` condition on column `oz_users`.`phone`.
	 *
	 * @return static
	 */
	public function wherePhoneIsNull(): self
	{
		return $this->filterBy(
			Operator::from('is_null'),
			\OZONE\Core\Db\OZUser::COL_PHONE
		);
	}

	/**
	 * Filters rows with `is_not_null` condition on column `oz_users`.`phone`.
	 *
	 * @return static
	 */
	public function wherePhoneIsNotNull(): self
	{
		return $this->filterBy(
			Operator::from('is_not_null'),
			\OZONE\Core\Db\OZUser::COL_PHONE
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`phone`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`phone`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function wherePhoneIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_PHONE,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIs(string $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsNot(string $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsLt(string $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsLte(string $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsGt(string $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsGte(string $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`email`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`email`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`email`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereEmailIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_EMAIL,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIs(string $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsNot(string $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsLt(string $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsLte(string $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsGt(string $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsGte(string $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`pass`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`pass`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`pass`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function wherePassIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_PASS,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIs(string $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsNot(string $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsLt(string $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsLte(string $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsGt(string $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsGte(string $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`name`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`name`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`name`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereNameIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_NAME,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIs(string $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsNot(string $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsLt(string $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsLte(string $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsGt(string $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsGte(string $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`gender`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`gender`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`gender`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereGenderIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_GENDER,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`birth_date`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIs(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`birth_date`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsNot(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`birth_date`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsLt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`birth_date`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsLte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`birth_date`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsGt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`birth_date`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsGte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`birth_date`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`birth_date`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`birth_date`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`birth_date`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereBirthDateIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_BIRTH_DATE,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIs(string $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsNot(string $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsLt(string $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsLte(string $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsGt(string $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsGte(string $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`pic`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `is_null` condition on column `oz_users`.`pic`.
	 *
	 * @return static
	 */
	public function wherePicIsNull(): self
	{
		return $this->filterBy(
			Operator::from('is_null'),
			\OZONE\Core\Db\OZUser::COL_PIC
		);
	}

	/**
	 * Filters rows with `is_not_null` condition on column `oz_users`.`pic`.
	 *
	 * @return static
	 */
	public function wherePicIsNotNull(): self
	{
		return $this->filterBy(
			Operator::from('is_not_null'),
			\OZONE\Core\Db\OZUser::COL_PIC
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`pic`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`pic`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function wherePicIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_PIC,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2Is(string $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsNot(string $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsLt(string $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsLte(string $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsGt(string $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsGte(string $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`cc2`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`cc2`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`cc2`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereCc2IsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_CC2,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`data`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereDataIs(array $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_DATA,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`data`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereDataIsNot(array $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_DATA,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`data`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereDataIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_DATA,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`data`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereDataIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_DATA,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`created_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIs(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`created_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsNot(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`created_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsLt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`created_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsLte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`created_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsGt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`created_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsGte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`created_at`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`created_at`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`created_at`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`created_at`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereCreatedAtIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_CREATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`updated_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIs(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`updated_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsNot(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `lt` condition on column `oz_users`.`updated_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsLt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lt'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `lte` condition on column `oz_users`.`updated_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsLte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('lte'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `gt` condition on column `oz_users`.`updated_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsGt(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gt'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `gte` condition on column `oz_users`.`updated_at`.
	 *
	 * @param int|string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsGte(string|int $value): self
	{
		return $this->filterBy(
			Operator::from('gte'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `like` condition on column `oz_users`.`updated_at`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('like'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `not_like` condition on column `oz_users`.`updated_at`.
	 *
	 * @param string $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsNotLike(string $value): self
	{
		return $this->filterBy(
			Operator::from('not_like'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `in` condition on column `oz_users`.`updated_at`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('in'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `not_in` condition on column `oz_users`.`updated_at`.
	 *
	 * @param array $value the filter value
	 *
	 * @return static
	 */
	public function whereUpdatedAtIsNotIn(array $value): self
	{
		return $this->filterBy(
			Operator::from('not_in'),
			\OZONE\Core\Db\OZUser::COL_UPDATED_AT,
			$value
		);
	}

	/**
	 * Filters rows with `eq` condition on column `oz_users`.`is_valid`.
	 *
	 * @param bool $value the filter value
	 *
	 * @return static
	 */
	public function whereIsValidIs(bool $value): self
	{
		return $this->filterBy(
			Operator::from('eq'),
			\OZONE\Core\Db\OZUser::COL_IS_VALID,
			$value
		);
	}

	/**
	 * Filters rows with `neq` condition on column `oz_users`.`is_valid`.
	 *
	 * @param bool $value the filter value
	 *
	 * @return static
	 */
	public function whereIsValidIsNot(bool $value): self
	{
		return $this->filterBy(
			Operator::from('neq'),
			\OZONE\Core\Db\OZUser::COL_IS_VALID,
			$value
		);
	}

	/**
	 * Filters rows with `is_false` condition on column `oz_users`.`is_valid`.
	 *
	 * @return static
	 */
	public function whereIsNotValid(): self
	{
		return $this->filterBy(
			Operator::from('is_false'),
			\OZONE\Core\Db\OZUser::COL_IS_VALID
		);
	}

	/**
	 * Filters rows with `is_true` condition on column `oz_users`.`is_valid`.
	 *
	 * @return static
	 */
	public function whereIsValid(): self
	{
		return $this->filterBy(
			Operator::from('is_true'),
			\OZONE\Core\Db\OZUser::COL_IS_VALID
		);
	}
}
