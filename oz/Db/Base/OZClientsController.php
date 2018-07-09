<?php
/**
 * Auto generated file, please don't edit.
 *
 * With: Gobl v1.0.0
 * Time: 1530471772
 */

	namespace OZONE\OZ\Db\Base;

	use Gobl\DBAL\Rule;
	use Gobl\ORM\Exceptions\ORMControllerFormException;
	use Gobl\ORM\ORM;
	use OZONE\OZ\Db\OZClient as OZClientReal;
	use OZONE\OZ\Db\OZClientsQuery as OZClientsQueryReal;

	/**
	 * Class OZClientsController
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZClientsController
	{
		/** @var array */
		protected $form_fields = [];
		/** @var array */
		protected $form_fields_mask = [];

		/**
		 * OZClientsController constructor.
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function __construct()
		{
			$table   = ORM::getDatabase()
						  ->getTable(OZClient::TABLE_NAME);
			$columns = $table->getColumns();

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
						->getTable(OZClient::TABLE_NAME);
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
		 * the column(s) to update really exists in `oz_clients`.
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
						->getTable(OZClient::TABLE_NAME);
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
		 * @param \OZONE\OZ\Db\Base\OZClientsQuery $query
		 * @param array                               $filters
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 * @throws \Exception
		 */
		final protected static function applyFilters(OZClientsQuery &$query, array $filters)
		{
			if (empty($filters)) {
				return;
			}

			$operators_map = [
				'eq'       => Rule::OP_EQ,
				'neq'      => Rule::OP_NEQ,
				'lt'       => Rule::OP_LT,
				'lte'      => Rule::OP_LTE,
				'gt'       => Rule::OP_GT,
				'gte'      => Rule::OP_GTE,
				'like'     => Rule::OP_LIKE,
				'not_like' => Rule::OP_NOT_LIKE,
				'in'       => Rule::OP_IN,
				'not_in'   => Rule::OP_NOT_IN
			];

			$table = ORM::getDatabase()
						->getTable(OZClient::TABLE_NAME);

			foreach ($filters as $column => $column_filters) {
				if (!$table->hasColumn($column)) {
					throw new ORMControllerFormException('form_filters_unknown_fields', [$column]);
				}

				if (is_array($column_filters)) {
					foreach ($column_filters as $filter) {
						if (is_array($filter)) {
							if (count($filter) !== 2 OR !isset($filter[0]) OR !isset($filter[1])) {
								throw new ORMControllerFormException('form_filters_invalid', [$column, $filter]);
							}

							$operator_key = $filter[0];
							$value        = $filter[1];

							if (!isset($operators_map[$operator_key])) {
								throw new ORMControllerFormException('form_filters_unknown_operator', [
									$column,
									$filter
								]);
							}

							$operator   = $operators_map[$operator_key];
							$safe_value = true;

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

							$query->filterBy($column, $value, $operator, false);
						}
					}
				} else {
					$value = $column_filters;
					$query->filterBy($column, $value, Rule::OP_EQ);
				}
			}
		}

		/**
		 * Adds item to `oz_clients`.
		 *
		 * @param array $values the row values
		 *
		 * @return \OZONE\OZ\Db\OZClient
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\DBAL\Types\Exceptions\TypesInvalidValueException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function addItem(array $values = [])
		{
			$this->completeForm($values);

			$my_entity = new OZClientReal();

			$my_entity->hydrate($values);
			$my_entity->save();

			return $my_entity;
		}

		/**
		 * Updates one item in `oz_clients`.
		 *
		 * The returned value will be:
		 * - `false` when the item was not found
		 * - `OZClient` when the item was successfully updated,
		 * when there is an error updating you can catch the exception
		 *
		 * @param array $filters    the row filters
		 * @param array $new_values the new values
		 *
		 * @return bool|\OZONE\OZ\Db\OZClient
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\DBAL\Types\Exceptions\TypesInvalidValueException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function updateOneItem(array $filters, array $new_values)
		{
			self::assertFiltersNotEmpty($filters);
			self::assertUpdateColumns(array_keys($new_values));

			$my_entity = self::getItem($filters);

			if ($my_entity) {
				$my_entity->hydrate($new_values);
				$my_entity->save();

				return $my_entity;
			} else {
				return false;
			}
		}

		/**
		 * Update all items in `oz_clients` that match the given item filters.
		 *
		 * @param array $filters    the row filters
		 * @param array $new_values the new values
		 *
		 * @return int Affected row count.
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function updateAllItems(array $filters, array $new_values)
		{
			self::assertFiltersNotEmpty($filters);
			$my_query = new OZClientsQueryReal();

			self::applyFilters($my_query, $filters);

			$affected = $my_query->update($new_values)
								 ->execute();

			return $affected;
		}

		/**
		 * Delete one item from `oz_clients`.
		 *
		 * The returned value will be:
		 * - `false` when the item was not found
		 * - `OZClient` when the item was successfully deleted,
		 * when there is an error deleting you can catch the exception
		 *
		 * @param array $filters the row filters
		 *
		 * @return bool|\OZONE\OZ\Db\OZClient
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function deleteOneItem(array $filters)
		{
			self::assertFiltersNotEmpty($filters);
			$my_entity = $this->getItem($filters);

			if ($my_entity) {
				$my_query = new OZClientsQueryReal();

				self::applyFilters($my_query, $filters);

				$my_query->delete()
						 ->execute();

				return $my_entity;
			} else {
				return false;
			}
		}

		/**
		 * Delete all items in `oz_clients` that match the given item filters.
		 *
		 * @param array $filters the row filters
		 *
		 * @return int Affected row count.
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function deleteAllItems(array $filters)
		{
			self::assertFiltersNotEmpty($filters);
			$my_query = new OZClientsQueryReal();

			self::applyFilters($my_query, $filters);

			$affected = $my_query->delete()
								 ->execute();

			return $affected;
		}

		/**
		 * Gets item from `oz_clients` that match the given filters.
		 *
		 * The returned value will be:
		 * - `null` when the item was not found
		 * - `OZClient` otherwise
		 *
		 * @param array $filters  the row filters
		 * @param array $order_by order by rules
		 *
		 * @return \OZONE\OZ\Db\OZClient|null
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function getItem(array $filters, array $order_by = [])
		{
			self::assertFiltersNotEmpty($filters);
			$results = $this->findAllItems($filters, 1, 0, $order_by);

			return $results->fetchClass();
		}

		/**
		 * Gets all items from `oz_clients` that match the given filters.
		 *
		 * @param array    $filters  the row filters
		 * @param null|int $max      maximum row to retrieve
		 * @param int      $offset   first row offset
		 * @param array    $order_by order by rules
		 * @param int|bool $total    total rows without limit
		 *
		 * @return \OZONE\OZ\Db\OZClient[]
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function getAllItems(array $filters = [], $max = null, $offset = 0, array $order_by = [], &$total = false)
		{
			$results = $this->findAllItems($filters, $max, $offset, $order_by);

			$items = $results->fetchAllClass();

			if ($total !== false) {
				$found = count($items);
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

			return $items;
		}

		/**
		 * Find all items in `oz_clients` that match the given filters.
		 *
		 * @param array    $filters  the row filters
		 * @param int|null $max      maximum row to retrieve
		 * @param int      $offset   first row offset
		 * @param array    $order_by order by rules
		 *
		 * @return \OZONE\OZ\Db\OZClientsResults
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function findAllItems(array $filters = [], $max = null, $offset = 0, array $order_by = [])
		{
			$my_query = new OZClientsQueryReal();

			if (!empty($filters)) {
				self::applyFilters($my_query, $filters);
			}

			$results = $my_query->find($max, $offset, $order_by);

			return $results;
		}

		// TODO
		// public function addOneItemRelation(array $filters, $relation, array $relation_values){}

		// TODO
		// public function updateOneItemRelation(array $filters, $relation, array $new_values) {}

		// TODO
		// public function deleteOneItemRelation(array $filters, $relation, $delete_max = 1, $delete_offset = 0) {}

		// TODO
		// public function getOneItemWithRelations(array $filters, array $relations, $max = null, $offset = 0) {}
	}