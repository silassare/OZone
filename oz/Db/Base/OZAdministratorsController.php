<?php
	/**
 * Auto generated file, please don't edit.
 *
 * With: Gobl v1.0.0
 * Time: 1551653125
 */

	namespace OZONE\OZ\Db\Base;

	use Gobl\CRUD\CRUD;
	use Gobl\DBAL\QueryBuilder;
	use Gobl\DBAL\Rule;
	use Gobl\ORM\Exceptions\ORMControllerFormException;
	use Gobl\ORM\Exceptions\ORMQueryException;
	use Gobl\ORM\ORM;
	use OZONE\OZ\Db\OZAdmin as OZAdminReal;
	use OZONE\OZ\Db\OZAdministratorsQuery as OZAdministratorsQueryReal;
	use OZONE\OZ\Db\OZAdministratorsResults as OZAdministratorsResultsReal;

	/**
	 * Class OZAdministratorsController
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZAdministratorsController
	{
		/**
		 * @var array
		 */
		protected $form_fields = [];

		/**
		 * @var array
		 */
		protected $form_fields_mask = [];

		/**
		 * @var \Gobl\DBAL\Db
		 */
		protected $db;

		/**
		 * @var \Gobl\CRUD\CRUD
		 */
		protected $crud;

		/**
		 * OZAdministratorsController constructor.
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Exception
		 */
		public function __construct()
		{
			$this->db = ORM::getDatabase();
			$table    = $this->db->getTable(OZAdmin::TABLE_NAME);
			$columns  = $table->getColumns();

			// we finds all required fields
			foreach ($columns as $column) {
				$full_name = $column->getFullName();
				$required  = true;
				$type      = $column->getTypeObject();
				if ($type->isAutoIncremented() OR $type->isNullAble() OR !is_null($type->getDefault())) {
					$required = false;
				}

				$this->form_fields[$full_name] = $required;
			}

			$this->crud = new CRUD($table);
		}

		/**
		 * Get required forms fields.
		 *
		 * @return array
		 */
		protected function getRequiredFields()
		{
			$fields = [];
			foreach ($this->form_fields as $field => $required) {
				if ($required === true) {
					$fields[] = $field;
				}
			}

			return $fields;
		}

		/**
		 * Complete form by adding missing fields.
		 *
		 * @param array &$form The form
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		protected function completeForm(array &$form)
		{
			$required_fields = $this->getRequiredFields();
			$completed       = true;
			$missing         = [];

			$table = ORM::getDatabase()
						->getTable(OZAdmin::TABLE_NAME);
			foreach ($required_fields as $field) {
				if (!isset($form[$field])) {
					$column  = $table->getColumn($field);
					$default = $column->getTypeObject()
									  ->getDefault();
					if (is_null($default)) {
						$completed = false;
						$missing[] = $field;
					} else {
						$form[$field] = $default;
					}
				}
			}

			if (!$completed) {
				throw new ORMControllerFormException('form_missing_fields', $missing);
			}
		}

		/**
		 * Asserts that there is at least one column to update and
		 * the column(s) to update really exists in `oz_administrators`.
		 *
		 * @param array $columns The columns list
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		protected static function assertUpdateColumns(array $columns = [])
		{
			if (empty($columns)) {
				throw new ORMControllerFormException('form_no_fields_to_update');
			}

			$table = ORM::getDatabase()
						->getTable(OZAdmin::TABLE_NAME);
			foreach ($columns as $column) {
				if (!$table->hasColumn($column)) {
					throw new ORMControllerFormException('form_unknown_fields', [$column]);
				}
			}
		}

		/**
		 * Asserts that the filters are not empty.
		 *
		 * @param array $filters the row filters
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 */
		protected static function assertFiltersNotEmpty(array $filters)
		{
			if (empty($filters)) {
				throw new ORMControllerFormException('form_filters_empty');
			}
		}

		/**
		 * Apply filters to the table query.
		 *
		 * $filters = [
		 *        'name'  => [
		 *            ['eq', 'value1'],
		 *            ['eq', 'value2']
		 *        ],
		 *        'age'   => [
		 *            ['lt' => 40],
		 *            ['gt' => 50]
		 *        ],
		 *        'valid' => 1
		 * ];
		 *
		 * (name = value1 OR name = value2) AND (age < 40 OR age > 50) AND (valid = 1)
		 *
		 * @param \OZONE\OZ\Db\Base\OZAdministratorsQuery $query
		 * @param array                               $filters
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Exception
		 */
		final protected static function applyFilters(OZAdministratorsQuery &$query, array $filters)
		{
			if (empty($filters)) {
				return;
			}

			$operators_map = [
				'eq'          => Rule::OP_EQ,
				'neq'         => Rule::OP_NEQ,
				'lt'          => Rule::OP_LT,
				'lte'         => Rule::OP_LTE,
				'gt'          => Rule::OP_GT,
				'gte'         => Rule::OP_GTE,
				'like'        => Rule::OP_LIKE,
				'not_like'    => Rule::OP_NOT_LIKE,
				'in'          => Rule::OP_IN,
				'not_in'      => Rule::OP_NOT_IN,
				'is_null'     => Rule::OP_IS_NULL,
				'is_not_null' => Rule::OP_IS_NOT_NULL
			];

			$table = ORM::getDatabase()
						->getTable(OZAdmin::TABLE_NAME);

			foreach ($filters as $column => $column_filters) {
				if (!$table->hasColumn($column)) {
					throw new ORMControllerFormException('form_filters_unknown_fields', [$column]);
				}

				if (is_array($column_filters)) {
					foreach ($column_filters as $filter) {
						if (is_array($filter)) {
							if (!isset($filter[0])) {
								throw new ORMControllerFormException('form_filters_invalid', [$column, $filter]);
							}

							$operator_key = $filter[0];

							if (!isset($operators_map[$operator_key])) {
								throw new ORMControllerFormException('form_filters_unknown_operator', [
									$column,
									$filter
								]);
							}

							$safe_value    = true;
							$operator      = $operators_map[$operator_key];
							$value         = null;
							$use_and       = false;
							$value_index   = 1;
							$use_and_index = 2;

							if ($operator === Rule::OP_IS_NULL OR $operator === Rule::OP_IS_NOT_NULL) {
								$use_and_index = 1;// value not needed
							} else {
								if (!isset($filter[$value_index])) {
									throw new ORMControllerFormException('form_filters_missing_value', [
										$column,
										$filter
									]);
								}

								$value = $filter[$value_index];

								if ($operator === Rule::OP_IN OR $operator === Rule::OP_NOT_IN) {
									$safe_value = is_array($value) AND count($value) ? true : false;
								} elseif (!is_scalar($value)) {
									$safe_value = false;
								}

								if (!$safe_value) {
									throw new ORMControllerFormException('form_filters_invalid_value', [
										$column,
										$filter
									]);
								}
							}

							if (isset($filter[$use_and_index])) {
								$a = $filter[$use_and_index];
								if ($a === "and" OR $a === "AND" OR $a === 1 OR $a === true) {
									$use_and = true;
								} elseif ($a === "or" OR $a === "OR" OR $a === 0 OR $a === false) {
									$use_and = false;
								} else {
									throw new ORMControllerFormException('form_filters_invalid', [
										$column,
										$filter
									]);
								}
							}

							$query->filterBy($column, $value, $operator, $use_and);
						} else {
							throw new ORMControllerFormException('form_filters_invalid', [
								$column,
								$filter
							]);
						}
					}
				} else {
					$value = $column_filters;
					$query->filterBy($column, $value, is_null($value) ? Rule::OP_IS_NULL : Rule::OP_EQ);
				}
			}
		}

		/**
		 * Adds item to `oz_administrators`.
		 *
		 * @param array $values the row values
		 *
		 * @return \OZONE\OZ\Db\OZAdmin
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\DBAL\Types\Exceptions\TypesInvalidValueException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function addItem(array $values = [])
		{
			$this->crud->assertCreate($values);

			$this->completeForm($values);

			$entity = new OZAdminReal();

			$entity->hydrate($values);
			$entity->save();

			$this->crud->getHandler()
					   ->onAfterCreateEntity($entity);

			return $entity;
		}

		/**
		 * Updates one item in `oz_administrators`.
		 *
		 * The returned value will be:
		 * - `false` when the item was not found
		 * - `OZAdmin` when the item was successfully updated,
		 * when there is an error updating you can catch the exception
		 *
		 * @param array $filters    the row filters
		 * @param array $new_values the new values
		 *
		 * @return bool|\OZONE\OZ\Db\OZAdmin
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\DBAL\Types\Exceptions\TypesInvalidValueException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 */
		public function updateOneItem(array $filters, array $new_values)
		{
			$this->crud->assertUpdate($filters, $new_values);

			self::assertFiltersNotEmpty($filters);
			self::assertUpdateColumns(array_keys($new_values));

			$results = $this->findAllItems($filters, 1, 0);

			$entity = $results->fetchClass();

			if ($entity) {
				$this->crud->getHandler()
						   ->onBeforeUpdateEntity($entity);

				$entity->hydrate($new_values);
				$entity->save();

				$this->crud->getHandler()
						   ->onAfterUpdateEntity($entity);

				return $entity;
			} else {
				return false;
			}
		}

		/**
		 * Update all items in `oz_administrators` that match the given item filters.
		 *
		 * @param array $filters    the row filters
		 * @param array $new_values the new values
		 *
		 * @return int Affected row count.
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 */
		public function updateAllItems(array $filters, array $new_values)
		{
			$this->crud->assertUpdateAll($filters, $new_values);

			self::assertFiltersNotEmpty($filters);

			$tableQuery = new OZAdministratorsQueryReal();

			self::applyFilters($tableQuery, $filters);

			$affected = $tableQuery->update($new_values)
								   ->execute();

			return $affected;
		}

		/**
		 * Delete one item from `oz_administrators`.
		 *
		 * The returned value will be:
		 * - `false` when the item was not found
		 * - `OZAdmin` when the item was successfully deleted,
		 * when there is an error deleting you can catch the exception
		 *
		 * @param array $filters the row filters
		 *
		 * @return bool|\OZONE\OZ\Db\OZAdmin
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 */
		public function deleteOneItem(array $filters)
		{
			$this->crud->assertDelete($filters);

			self::assertFiltersNotEmpty($filters);

			$results = $this->findAllItems($filters, 1, 0);

			$entity = $results->fetchClass();

			if ($entity) {
				$this->crud->getHandler()
						   ->onBeforeDeleteEntity($entity);

				$tableQuery = new OZAdministratorsQueryReal();

				self::applyFilters($tableQuery, $filters);

				$tableQuery->delete()
						   ->execute();

				$this->crud->getHandler()
						   ->onAfterDeleteEntity($entity);

				return $entity;
			} else {
				return false;
			}
		}

		/**
		 * Delete all items in `oz_administrators` that match the given item filters.
		 *
		 * @param array $filters the row filters
		 *
		 * @return int Affected row count.
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 */
		public function deleteAllItems(array $filters)
		{
			$this->crud->assertDeleteAll($filters);

			self::assertFiltersNotEmpty($filters);

			$tableQuery = new OZAdministratorsQueryReal();

			self::applyFilters($tableQuery, $filters);

			$affected = $tableQuery->delete()
								   ->execute();

			return $affected;
		}

		/**
		 * Gets item from `oz_administrators` that match the given filters.
		 *
		 * The returned value will be:
		 * - `null` when the item was not found
		 * - `OZAdmin` otherwise
		 *
		 * @param array $filters  the row filters
		 * @param array $order_by order by rules
		 *
		 * @return \OZONE\OZ\Db\OZAdmin|null
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function getItem(array $filters, array $order_by = [])
		{
			$this->crud->assertRead($filters);

			self::assertFiltersNotEmpty($filters);

			$results = $this->findAllItems($filters, 1, 0, $order_by);

			$entity = $results->fetchClass();

			if ($entity) {
				$this->crud->getHandler()
						   ->onAfterReadEntity($entity);
			}

			return $entity;
		}

		/**
		 * Gets all items from `oz_administrators` that match the given filters.
		 *
		 * @param array    $filters  the row filters
		 * @param null|int $max      maximum row to retrieve
		 * @param int      $offset   first row offset
		 * @param array    $order_by order by rules
		 * @param int|bool $total    total rows without limit
		 *
		 * @return \OZONE\OZ\Db\OZAdmin[]
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 */
		public function getAllItems(array $filters = [], $max = null, $offset = 0, array $order_by = [], &$total = false)
		{
			$this->crud->assertReadAll($filters);

			$results = $this->findAllItems($filters, $max, $offset, $order_by);

			$items = $results->fetchAllClass();

			$total = self::totalResultsCount($results, count($items), $max, $offset);

			return $items;
		}

		/**
		 * Gets all items from `oz_administrators` with a custom query builder instance.
		 *
		 * @param \Gobl\DBAL\QueryBuilder $qb
		 * @param null|int                $max    maximum row to retrieve
		 * @param int                     $offset first row offset
		 * @param int|bool                $total  total rows without limit
		 *
		 * @return \OZONE\OZ\Db\OZAdmin[]
		 * @throws \Gobl\CRUD\Exceptions\CRUDException
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function getAllItemsCustom(QueryBuilder $qb, $max = null, $offset = 0, &$total = false)
		{
			$filters = [];

			$this->crud->assertReadAll($filters);

			$qb->limit($max, $offset);

			$results = new OZAdministratorsResultsReal($this->db, $qb);

			$items = $results->fetchAllClass(false);

			$total = self::totalResultsCount($results, count($items), $max, $offset);

			return $items;
		}

		/**
		 * @param \OZONE\OZ\Db\OZAdministratorsResults $results
		 * @param int                         $found
		 * @param null|int                    $max
		 * @param int                         $offset
		 *
		 * @return int
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		private static function totalResultsCount(OZAdministratorsResultsReal $results, $found = 0, $max = null, $offset = 0)
		{
			$total = 0;
			if ($total !== false) {
				if (isset($max)) {
					if ($found < $max) {
						$total = $offset + $found;
					} else {
						$total = $results->totalCount();
					}
				} elseif ($offset === 0) {
					$total = $found;
				} else {
					$total = $results->totalCount();
				}
			}

			return $total;
		}

		/**
		 * Gets collection items from `oz_administrators`.
		 *
		 * @param string   $name
		 * @param array    $filters
		 * @param null|int $max
		 * @param int      $offset
		 * @param array    $order_by
		 * @param bool     $total_records
		 *
		 * @return \OZONE\OZ\Db\OZAdmin[]
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Gobl\ORM\Exceptions\ORMQueryException
		 */
		public function getCollectionItems($name, array $filters = [], $max = null, $offset = 0, array $order_by = [], &$total_records = false)
		{
			$table      = ORM::getDatabase()
							 ->getTable(OZAdmin::TABLE_NAME);
			$collection = $table->getCollection($name);

			if (!$collection) {
				throw new ORMQueryException("QUERY_INVALID_COLLECTION");
			}

			return $collection->run($filters, $max, $offset, $order_by, $total_records);
		}

		/**
		 * Find all items in `oz_administrators` that match the given filters.
		 *
		 * @param array    $filters  the row filters
		 * @param int|null $max      maximum row to retrieve
		 * @param int      $offset   first row offset
		 * @param array    $order_by order by rules
		 *
		 * @return \OZONE\OZ\Db\OZAdministratorsResults
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		private function findAllItems(array $filters = [], $max = null, $offset = 0, array $order_by = [])
		{
			$tableQuery = new OZAdministratorsQueryReal();

			if (!empty($filters)) {
				self::applyFilters($tableQuery, $filters);
			}

			$results = $tableQuery->find($max, $offset, $order_by);

			return $results;
		}

		/**
		 * @return \Gobl\CRUD\CRUD
		 * @throws \Exception
		 */
		public function getCRUD()
		{
			if (!$this->crud) {
				throw new \Exception("Not using CRUD rules");
			}

			return $this->crud;
		}
	}