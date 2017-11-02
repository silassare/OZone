<?php
	/**
	 * Auto generated file, please don't edit.
	 *
	 * With: Gobl v1.0.0
	 * Time: 1509638392
	 */

	namespace OZONE\OZ\Db\Base;

	use Gobl\DBAL\Rule;
	use Gobl\ORM\Exceptions\ORMControllerFormException;
	use Gobl\ORM\ORM;
	use OZONE\OZ\Db\OZAuth as OZAuthReal;
	use OZONE\OZ\Db\OZAuthenticatorQuery;

	/**
	 * Class OZAuthenticatorController
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZAuthenticatorController
	{
		/** @var array */
		protected $form_fields = [];

		/**
		 * OZAuthenticatorController constructor.
		 */
		public function __construct()
		{
			$table   = ORM::getDatabase()
						  ->getTable('oz_authenticator');
			$columns = $table->getColumns();

			// we finds all required fields
			foreach ($columns as $column) {
				$full_name = $column->getFullName();
				$required  = false;
				if (!$column->isAutoIncrement()) {
					if (!$column->isNullAble() AND is_null($column->getDefaultValue())) {
						$required = true;
					}
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
		 * Asserts that all required fields are in the form.
		 *
		 * @param array $form            The form
		 * @param array $required_fields Required fields list
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 */
		protected static function assertFormCompleted(array $form, array $required_fields = [])
		{
			$completed = true;
			$missing   = [];
			foreach ($required_fields as $field) {
				if (!isset($form[$field])) {
					$completed = false;
					$missing[] = $field;
				}
			}

			if (!$completed) {
				throw new ORMControllerFormException('form_missing_fields', $missing);
			}
		}

		/**
		 * Asserts that there is at least one column to update and
		 * the column(s) to update really exists in `oz_authenticator`.
		 *
		 * @param array $columns The columns list
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 */
		protected static function assertUpdateColumns(array $columns = [])
		{
			if (empty($columns)) {
				throw new ORMControllerFormException('form_no_column_to_update');
			}

			$table = ORM::getDatabase()
						->getTable('oz_authenticator');
			foreach ($columns as $column) {
				if (!$table->hasColumn($column)) {
					throw new ORMControllerFormException('form_unknown_column', [$column]);
				}
			}
		}

		/**
		 * Asserts that the item filters is not empty.
		 *
		 * @param array $item_filters
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 */
		protected static function assertFiltersNotEmpty(array $item_filters)
		{
			if (empty($item_filters)) {
				throw new ORMControllerFormException('form_filters_empty');
			}
		}

		/**
		 * Apply item filters to the table query.
		 *
		 * $item_filters = [
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
		 * @param \OZONE\OZ\Db\OZAuthenticatorQuery $query
		 * @param array                       $item_filters
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMControllerFormException
		 */
		final protected static function applyFilters(OZAuthenticatorQuery &$query, array $item_filters)
		{
			if (empty($item_filters)) {
				return;
			}

			$operators_map = [
				'eq'   => Rule::OP_EQ,
				'neq'  => Rule::OP_NEQ,
				'lt'   => Rule::OP_LT,
				'lte'  => Rule::OP_LTE,
				'gt'   => Rule::OP_GT,
				'gte'  => Rule::OP_GTE,
				'like' => Rule::OP_LIKE
			];

			$table = ORM::getDatabase()
						->getTable('oz_authenticator');

			foreach ($item_filters as $column => $filters) {
				if (!$table->hasColumn($column)) {
					throw new ORMControllerFormException('form_filters_unknown_column', [$column]);
				}

				if (is_array($filters)) {
					foreach ($filters as $filter) {
						if (is_array($filter)) {
							if (count($filter) !== 2 OR !isset($filter[0]) OR !isset($filter[1])) {
								throw new ORMControllerFormException('form_filters_invalid', [$column, $filter]);
							}

							$operator = $filter[0];
							$value    = $filter[1];

							if (!isset($operators_map[$operator])) {
								throw new ORMControllerFormException('form_filters_unknown_operator', [
									$column,
									$filter
								]);
							}

							if (!is_scalar($value)) {
								throw new ORMControllerFormException('form_filters_invalid_value', [
									$column,
									$filter
								]);
							}

							$query->filterBy($column, $value, $operators_map[$operator]);
						}
					}
				} else {
					$value = $filters;
					$query->filterBy($column, $value, Rule::OP_EQ);
				}
			}
		}

		/**
		 * Adds item to `oz_authenticator`.
		 *
		 * @param array $form
		 *
		 * @return \OZONE\OZ\Db\OZAuth
		 */
		public function addItem(array $form = [])
		{
			$required_fields = $this->getRequiredFields();

			self::assertFormCompleted($form, $required_fields);

			$my_entity = new OZAuthReal();

			$my_entity->hydrate($form);
			$my_entity->save();

			return $my_entity;
		}

		/**
		 * Updates one item in `oz_authenticator`.
		 *
		 * The returned value will be:
		 * - `false` when the item was not found
		 * - `OZAuth` when the item was successfully updated,
		 * when there is an error updating you can catch the exception
		 *
		 * @param array $item_filters the item filters
		 * @param array $new_values   the item new values
		 *
		 * @return bool|\OZONE\OZ\Db\OZAuth
		 */
		public function updateOneItem(array $item_filters, array $new_values)
		{
			self::assertFiltersNotEmpty($item_filters);
			self::assertUpdateColumns(array_keys($new_values));

			$my_entity = self::getItem($item_filters);

			if ($my_entity) {
				$my_entity->hydrate($new_values);
				$my_entity->save();

				return $my_entity;
			} else {
				return false;
			}
		}

		/**
		 * Delete one item from `oz_authenticator`.
		 *
		 * The returned value will be:
		 * - `false` when the item was not found
		 * - `OZAuth` when the item was successfully deleted,
		 * when there is an error deleting you can catch the exception
		 *
		 * @param array $item_filters the item filters
		 *
		 * @return bool|\OZONE\OZ\Db\OZAuth
		 */
		public function deleteOneItem(array $item_filters)
		{
			self::assertFiltersNotEmpty($item_filters);
			$my_entity = $this->getItem($item_filters);

			if ($my_entity) {
				$my_query = new OZAuthenticatorQuery();

				self::applyFilters($my_query, $item_filters);

				$my_query->delete()
						 ->execute();

				return $my_entity;
			} else {
				return false;
			}
		}

		/**
		 * Delete all items in `oz_authenticator` that match the given item filters.
		 *
		 * @param array $item_filters the item filters
		 *
		 * @return int Affected row count.
		 */
		public function deleteAllItem(array $item_filters)
		{
			self::assertFiltersNotEmpty($item_filters);
			$my_query = new OZAuthenticatorQuery();

			self::applyFilters($my_query, $item_filters);

			$affected = $my_query->delete()
								 ->execute();

			return $affected;
		}

		/**
		 * Gets item from `oz_authenticator` that match the given filters.
		 *
		 * The returned value will be:
		 * - `null` when the item was not found
		 * - `OZAuth` otherwise
		 *
		 * @param array $item_filters
		 *
		 * @return \OZONE\OZ\Db\OZAuth|null
		 */
		public function getItem(array $item_filters)
		{
			self::assertFiltersNotEmpty($item_filters);
			$results = $this->findAllItems($item_filters, 1, 0);

			return $results->fetchClass();
		}

		/**
		 * Gets all items from `oz_authenticator` that match the given filters.
		 *
		 * @param array $item_filters
		 * @param int   $max
		 * @param int   $offset
		 *
		 * @return \OZONE\OZ\Db\OZAuth[]
		 */
		public function getAllItems(array $item_filters = [], $max = null, $offset = 0)
		{
			$results = $this->findAllItems($item_filters, $max, $offset);

			return $results->fetchAllClass();
		}

		/**
		 * Find all items in `oz_authenticator` that match the given filters.
		 *
		 * @param array $item_filters
		 *
		 * @param int   $max
		 * @param int   $offset
		 *
		 * @return \OZONE\OZ\Db\OZAuthenticatorResults
		 */
		public function findAllItems(array $item_filters = [], $max = null, $offset = 0)
		{
			$my_query = new OZAuthenticatorQuery();

			if (!empty($item_filters)) {
				self::applyFilters($my_query, $item_filters);
			}

			$results = $my_query->find($max, $offset);

			return $results;
		}

		public function addOneItemRelation(array $item_filters, $relation, array $relation_values)
		{
			// TODO
		}

		public function updateOneItemRelation(array $item_filters, $relation, array $new_values)
		{
			// TODO
		}

		public function deleteOneItemRelation(array $item_filters, $relation, $delete_max = 1, $delete_offset = 0)
		{
			// TODO
		}

		public function getOneItemWithRelations(array $item_filters, array $relations, $max = null, $offset = 0)
		{
			// TODO
		}
	}