<?php
	/**
	 * Auto generated file, please don't edit.
	 *
	 * With: Gobl v1.0.0
	 * Time: 1509638392
	 */

	namespace OZONE\OZ\Db\Base;

	use Gobl\DBAL\Exceptions\DBALException;
	use Gobl\DBAL\QueryBuilder;
	use Gobl\DBAL\Rule;
	use Gobl\ORM\ORM;

	/**
	 * Class OZAuthenticatorQuery
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZAuthenticatorQuery
	{
		/** @var \Gobl\DBAL\Table */
		protected $table;
		/** @var string */
		protected $table_alias;
		/** @var \Gobl\DBAL\Db */
		protected $db;
		/** @var int */
		protected $alias_counter = 0;
		/** @var \Gobl\DBAL\QueryBuilder */
		protected $qb;
		/** @var \Gobl\DBAL\Rule[] */
		protected $filters = [];
		/** @var array */
		protected $params = [];

		/**
		 * OZAuthenticatorQuery constructor.
		 */
		public function __construct()
		{
			$this->db          = ORM::getDatabase();
			$this->table       = $this->db->getTable('oz_authenticator');
			$this->table_alias = $this->getUniqueAlias();
			$this->qb          = new QueryBuilder($this->db);
		}

		/**
		 * Finds rows in the table `oz_authenticator`.
		 *
		 * When filters exists only rows that
		 * satisfy the filters are returned.
		 *
		 * @param null|int $max    maximum row to retrieve
		 * @param int      $offset first row offset
		 *
		 * @return \OZONE\OZ\Db\OZAuthenticatorResults
		 */
		public function find($max = null, $offset = 0)
		{
			$this->qb->select()
					 ->from($this->table->getFullName(), $this->table_alias);

			$rule = $this->_getFiltersRule();
			if (!is_null($rule)) {
				$this->qb->where($rule);
			}

			$this->qb->limit($max, $offset)
					 ->bindArray($this->params);

			return new \OZONE\OZ\Db\OZAuthenticatorResults($this->db, $this, $this->resetQuery());
		}

		/**
		 * Delete rows in the table `oz_authenticator`.
		 *
		 * When filters exists only rows that
		 * satisfy the filters are deleted.
		 *
		 * @return \Gobl\DBAL\QueryBuilder
		 */
		public function delete()
		{
			$this->qb->delete()
					 ->from($this->table->getFullName(), $this->table_alias);

			$rule = $this->_getFiltersRule();
			if (!is_null($rule)) {
				$this->qb->where($rule);
			}
			$this->qb->bindArray($this->params);

			return $this->resetQuery();
		}

		/**
		 * Update rows in the table `oz_authenticator`.
		 *
		 * When filters exists only rows that
		 * satisfy the filters are updated.
		 *
		 * @param array $set_columns new values
		 *
		 * @return \Gobl\DBAL\QueryBuilder
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function update(array $set_columns)
		{
			if (!count($set_columns)) {
				throw new DBALException('Empty columns, cannot update.');
			}

			$this->qb->update($this->table->getFullName(), $this->table_alias);

			$rule = $this->_getFiltersRule();
			if (!is_null($rule)) {
				$this->qb->where($rule);
			}

			$columns = [];
			foreach ($set_columns as $column => $value) {
				$this->table->assertHasColumn($column);
				$columns[]      = $column;
				$this->params[] = $value;
			}

			$this->qb->set($columns)
					 ->bindArray($this->params);

			return $this->resetQuery();
		}

		/**
		 * Safely update rows in the table `oz_authenticator`.
		 *
		 * @param array $old_values old values
		 * @param array $new_values new values
		 *
		 * @return int affected rows count
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function safeUpdate(array $old_values, array $new_values)
		{
			$this->resetQuery();

			foreach ($this->table->getColumns() as $column_name => $column) {
				if (!array_key_exists($column_name, $old_values)) {
					throw new DBALException(sprintf('Missing column "%s" in old_values.', $column_name));
				}
				if (!array_key_exists($column_name, $new_values)) {
					throw new DBALException(sprintf('Missing column "%s" in new_values.', $column_name));
				}
			}

			if ($this->table->hasPrimaryKeyConstraint()) {
				$pk = $this->table->getPrimaryKeyConstraint();
				foreach ($pk->getConstraintColumns() as $key) {
					$this->filterBy($key, $old_values[$key]);
				}
			} else {
				foreach ($old_values as $column => $value) {
					$this->filterBy($column, $value);
				}
			}

			return $this->update($new_values)
						->execute(); // affected row count
		}

		/**
		 * Adds when row does not exists, otherwise update.
		 *
		 * This check existence with primary key only.
		 *
		 * @param array $row
		 *
		 * @return int|string int affected row, string last insert id
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function addOrUpdate(array $row)
		{
			$this->resetQuery();

			foreach ($this->table->getColumns() as $column_name => $column) {
				if (!array_key_exists($column_name, $row)) {
					throw new DBALException(sprintf('Missing column "%s" in row.', $column_name));
				}
			}

			$is_new = true;

			// Todo check unique constraint.
			if ($this->table->hasPrimaryKeyConstraint()) {
				$pk = $this->table->getPrimaryKeyConstraint();
				foreach ($pk->getConstraintColumns() as $key) {
					$this->filterBy($key, $row[$key]);
				}

				$results = $this->find();

				if ($results->count()) {
					$is_new = false;
				}
			}

			$entity = new \OZONE\OZ\Db\OZAuth($is_new);
			$entity->hydrate($row);

			return $entity->save();
		}

		/**
		 * Filters rows in the table `oz_authenticator`.
		 *
		 * @param string $column   the column name
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterBy($column, $value, $operator = Rule::OP_EQ)
		{
			// maybe user make change to the table without regenerating the classes
			$this->table->assertHasColumn($column);

			$head      = false;
			$full_name = $this->table->getColumn($column)
									 ->getFullName();

			if (!isset($this->filters[$full_name])) {
				$this->filters[$full_name] = new Rule($this->qb);
				$head                      = true;
			}

			$rule = $this->filters[$full_name];

			if (!$head) {
				$rule->andX();
			}

			$a = $this->table_alias . '.' . $full_name;
			$rule->conditions([$a => '?'], $operator, false);

			$this->params[] = $value;

			return $this;
		}


		/**
		 * Filters rows with condition on column `label` in the table `oz_authenticator`.
		 *
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterByLabel($value, $operator = Rule::OP_EQ)
		{
		    return $this->filterBy('label', $value, $operator);
		}

		/**
		 * Filters rows with condition on column `for` in the table `oz_authenticator`.
		 *
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterByFor($value, $operator = Rule::OP_EQ)
		{
		    return $this->filterBy('for', $value, $operator);
		}

		/**
		 * Filters rows with condition on column `code` in the table `oz_authenticator`.
		 *
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterByCode($value, $operator = Rule::OP_EQ)
		{
		    return $this->filterBy('code', $value, $operator);
		}

		/**
		 * Filters rows with condition on column `token` in the table `oz_authenticator`.
		 *
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterByToken($value, $operator = Rule::OP_EQ)
		{
		    return $this->filterBy('token', $value, $operator);
		}

		/**
		 * Filters rows with condition on column `try_max` in the table `oz_authenticator`.
		 *
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterByTryMax($value, $operator = Rule::OP_EQ)
		{
		    return $this->filterBy('try_max', $value, $operator);
		}

		/**
		 * Filters rows with condition on column `try_count` in the table `oz_authenticator`.
		 *
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterByTryCount($value, $operator = Rule::OP_EQ)
		{
		    return $this->filterBy('try_count', $value, $operator);
		}

		/**
		 * Filters rows with condition on column `expire` in the table `oz_authenticator`.
		 *
		 * @param mixed  $value    the filter value
		 * @param int    $operator the operator to use
		 *
		 * @return $this|\OZONE\OZ\Db\OZAuthenticatorQuery
		 */
		public function filterByExpire($value, $operator = Rule::OP_EQ)
		{
		    return $this->filterBy('expire', $value, $operator);
		}


		/**
		 * Creates new query builder and returns the old query builder.
		 *
		 * @return \Gobl\DBAL\QueryBuilder
		 */
		protected function resetQuery()
		{
			$qb           = $this->qb;
			$this->qb     = new QueryBuilder($this->db);
			$this->params = [];

			return $qb;
		}

		/**
		 * Returns a rule that include all filters rules.
		 *
		 * @return \Gobl\DBAL\Rule|null
		 */
		protected function _getFiltersRule()
		{
			if (count($this->filters)) {
				/** @var \Gobl\DBAL\Rule $rule */
				$rule = null;
				foreach ($this->filters as $r) {
					if (!$rule) {
						$rule = $r;
					} else {
						$rule->andX($r);
					}
				}

				return $rule;
			}

			return null;
		}

		/**
		 * Returns unique alias.
		 *
		 * infinite possibilities
		 * a,  b  ... z
		 * aa, ab ... az
		 * ba, bb ... bz
		 *
		 * @return string
		 */
		protected function getUniqueAlias()
		{
			$x    = $this->alias_counter++;
			$list = range('a', 'z');
			$len  = count($list);
			$a    = '';
			do {
				$r = ($x % $len);
				$n = ($x - $r) / $len;
				$x = $n - 1;
				$a = $list[$r] . $a;
			} while ($n);

			return '_' . $a . '_';
		}
	}