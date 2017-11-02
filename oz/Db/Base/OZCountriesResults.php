<?php
	/**
	 * Auto generated file, please don't edit.
	 *
	 * With: Gobl v1.0.0
	 * Time: 1509638392
	 */

	namespace OZONE\OZ\Db\Base;

	use Gobl\DBAL\Db;
	use Gobl\DBAL\QueryBuilder;
	use Gobl\ORM\Exceptions\ORMException;

	/**
	 * Class OZCountriesResults
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZCountriesResults implements \Countable, \Iterator
	{
		/** @var \Gobl\DBAL\Db */
		protected $db;
		/** @var \OZONE\OZ\Db\Base\OZCountriesQuery */
		protected $table_manager;
		/** @var \Gobl\DBAL\QueryBuilder */
		protected $query;
		/** @var int */
		protected $index = 0;
		/** @var array|null|\OZONE\OZ\Db\OZCountry */
		protected $current = null;
		/** @var  int */
		protected $count_cache = null;
		/** @var bool */
		protected $trust_row_count = true;
		/** @var \OZONE\OZ\Db\OZCountry */
		protected $entity = null;
		/** @var int */
		protected $fetch_style = \PDO::FETCH_ASSOC;
		/** @var int */
		protected $foreach_count = 0;
		/** @var bool */
		protected $iterate_class = true;

		/** @var \PDOStatement */
		private $statement = null;

		/**
		 * OZCountriesResults constructor.
		 *
		 * @param \Gobl\DBAL\Db               $db
		 * @param \OZONE\OZ\Db\Base\OZCountriesQuery $table_manager
		 * @param \Gobl\DBAL\QueryBuilder     $query
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function __construct(Db $db, OZCountriesQuery $table_manager, QueryBuilder $query)
		{
			if ($query->getType() !== QueryBuilder::QUERY_TYPE_SELECT) {
				throw new ORMException('The query should be a selection.');
			}

			$this->db            = $db;
			$this->table_manager = $table_manager;
			$this->query         = $query;
			$driver              = $db->getConnection()
									  ->getAttribute(\PDO::ATTR_DRIVER_NAME);
			// TODO search and verify source
			//  - we should not trust rowCount
			//  - sqlite 3.x does not support rowCount
			$this->trust_row_count = ($driver === 'sqlite' ? false : true);
		}

		/**
		 * Runs the current query and returns a statement.
		 *
		 * We lazily run query.
		 *
		 * @return \PDOStatement
		 */
		protected function getStatement()
		{
			if (!isset($this->statement)) {
				$this->statement = $this->query->execute();
			}

			return $this->statement;
		}

		/**
		 * Will disable iteration on entity class.
		 *
		 * @return $this|\OZONE\OZ\Db\OZCountriesResults
		 */
		public function iterateAssoc()
		{
			$this->iterate_class = false;

			return $this;
		}

		/**
		 * Fetches the next row in foreach mode.
		 *
		 * @return array|null|\OZONE\OZ\Db\OZCountry
		 */
		protected function runFetch()
		{
			if ($this->iterate_class) {
				return $this->fetchClass();
			}

			return $this->fetch();
		}

		/**
		 * Fetches the next row into table OZCountry class instance.
		 *
		 * @return null|\OZONE\OZ\Db\OZCountry
		 */
		public function fetchClass()
		{
			if ($this->entity === null) {
				$this->entity = new \OZONE\OZ\Db\OZCountry(false);
			}

			if ($this->fetch_style !== \PDO::FETCH_INTO) {
				$this->getStatement()
					 ->setFetchMode(\PDO::FETCH_INTO, $this->entity);
			}

			return $this->getStatement()
						->fetch();
		}

		/**
		 * Fetches all rows and return array of OZCountry class instance.
		 *
		 * @return \OZONE\OZ\Db\OZCountry[]
		 */
		public function fetchAllClass()
		{
			$this->fetch_style = \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE;
			$entity_class      = \OZONE\OZ\Db\OZCountry::class;

			return $this->getStatement()
						->fetchAll($this->fetch_style, $entity_class, [false]);
		}

		/**
		 * Fetches the next row.
		 *
		 * @param int $fetch_style
		 *
		 * @return mixed
		 */
		public function fetch($fetch_style = \PDO::FETCH_ASSOC)
		{
			$this->fetch_style = $fetch_style;

			return $this->getStatement()
						->fetch($fetch_style);
		}

		/**
		 * Returns an array containing all of the result set rows.
		 *
		 * @param int $fetch_style
		 *
		 * @return array
		 */
		public function fetchAll($fetch_style = \PDO::FETCH_ASSOC)
		{
			$this->fetch_style = $fetch_style;

			return $this->getStatement()
						->fetchAll($fetch_style);
		}

		/**
		 * Return the current element.
		 *
		 * @return array|null|\OZONE\OZ\Db\OZCountry
		 */
		public function current()
		{
			return $this->current;
		}

		/**
		 * Move forward to next element.
		 */
		public function next()
		{
			$this->current = $this->runFetch();

			if ($this->current) {
				$this->index++;
			}
		}

		/**
		 * Return the key of the current element.
		 *
		 * @return mixed scalar on success, or null on failure.
		 */
		public function key()
		{
			return $this->index;
		}

		/**
		 * Checks if current position is valid.
		 *
		 * @return boolean Returns true on success or false on failure.
		 */
		public function valid()
		{
			return !($this->current === null OR $this->current === false);
		}

		/**
		 * Rewind the Iterator to the first element.
		 *
		 * @return void Any returned value is ignored.
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function rewind()
		{
			// not supported
			if ($this->foreach_count) {
				throw new ORMException('You cannot use the same result set in multiple foreach.');
			}

			$this->current = $this->runFetch();

			$this->foreach_count++;
		}

		/**
		 * Count elements of an object.
		 *
		 * @return int The custom count as an integer.
		 */
		public function count()
		{
			if ($this->count_cache === null) {
				if ($this->trust_row_count === false) {
					$sql               = $this->query->getSqlQuery();
					$sql               = 'SELECT ' . 'COUNT(*) FROM (' . $sql . ')';
					$req               = $this->db->execute($sql, $this->query->getBoundValues(), $this->query->getBoundValuesTypes());
					$this->count_cache = (int)$req->fetchColumn();
				} else {
					$this->count_cache = $this->getStatement()
											  ->rowCount();
				}
			}

			return $this->count_cache;
		}
	}