<?php
	/**
 * Auto generated file, please don't edit.
 *
 * With: Gobl v1.0.0
 * Time: 1551653125
 */

	namespace OZONE\OZ\Db\Base;

	use Gobl\DBAL\Db;
	use Gobl\DBAL\QueryBuilder;
	use Gobl\ORM\Exceptions\ORMException;

	/**
	 * Class OZSessionsResults
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZSessionsResults implements \Countable, \Iterator
	{
		/** @var \Gobl\DBAL\Db */
		protected $db;
		/** @var \Gobl\DBAL\QueryBuilder */
		protected $query;
		/** @var int */
		protected $index = 0;
		/** @var array|null|\OZONE\OZ\Db\OZSession */
		protected $current = null;
		/** @var  int */
		protected $limited_count_cache = null;
		/** @var  int */
		protected $total_count_cache = null;
		/** @var bool */
		protected $trust_row_count = true;
		/** @var int */
		protected $foreach_count = 0;
		/** @var bool */
		protected $iterate_class = true;

		/** @var \PDOStatement */
		private $statement = null;

		/**
		 * OZSessionsResults constructor.
		 *
		 * @param \Gobl\DBAL\Db           $db
		 * @param \Gobl\DBAL\QueryBuilder $query
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function __construct(Db $db, QueryBuilder $query)
		{
			if ($query->getType() !== QueryBuilder::QUERY_TYPE_SELECT) {
				throw new ORMException('The query should be a selection.');
			}

			$this->db    = $db;
			$this->query = $query;
			$driver      = $db->getConnection()
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
		 * @throws \Gobl\DBAL\Exceptions\DBALException
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
		 * @return $this|\OZONE\OZ\Db\OZSessionsResults
		 */
		public function iterateAssoc()
		{
			$this->iterate_class = false;

			return $this;
		}

		/**
		 * Fetches the next row in foreach mode.
		 *
		 * @return array|null|\OZONE\OZ\Db\OZSession
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		protected function runFetch()
		{
			if ($this->iterate_class) {
				return $this->fetchClass();
			}

			return $this->fetch();
		}

		/**
		 * Fetches the next row into table OZSession class instance.
		 *
		 * @param bool $strict enable/disable strict mode on class fetch
		 *
		 * @return null|\OZONE\OZ\Db\OZSession
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function fetchClass($strict = true)
		{
			$entity = new \OZONE\OZ\Db\OZSession(false, $strict);
			$stmt   = $this->getStatement();

			$stmt->setFetchMode(\PDO::FETCH_INTO, $entity);

			return $stmt->fetch();
		}

		/**
		 * Fetches all rows and return array of OZSession class instance.
		 *
		 * @param bool $strict enable/disable strict mode on class fetch
		 *
		 * @return \OZONE\OZ\Db\OZSession[]
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function fetchAllClass($strict = true)
		{
			$fetch_style  = \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE;
			$entity_class = \OZONE\OZ\Db\OZSession::class;

			return $this->getStatement()
						->fetchAll($fetch_style, $entity_class, [false, $strict]);
		}

		/**
		 * Fetches the next row.
		 *
		 * @param int $fetch_style
		 *
		 * @return mixed
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function fetch($fetch_style = \PDO::FETCH_ASSOC)
		{
			return $this->getStatement()
						->fetch($fetch_style);
		}

		/**
		 * Returns an array containing all of the result set rows.
		 *
		 * @param int $fetch_style
		 *
		 * @return array
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function fetchAll($fetch_style = \PDO::FETCH_ASSOC)
		{
			return $this->getStatement()
						->fetchAll($fetch_style);
		}

		/**
		 * Return the current element.
		 *
		 * @return array|null|\OZONE\OZ\Db\OZSession
		 */
		public function current()
		{
			return $this->current;
		}

		/**
		 * Move forward to next element.
		 *
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 * @throws \Gobl\ORM\Exceptions\ORMException
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
		 * @throws \Gobl\DBAL\Exceptions\DBALException
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
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function count()
		{
			if ($this->limited_count_cache === null) {
				if ($this->trust_row_count === false) {
					$this->limited_count_cache = $this->query->runTotalRowsCount();
				} else {
					$this->limited_count_cache = $this->getStatement()
													  ->rowCount();
				}
			}

			return $this->limited_count_cache;
		}

		/**
		 * Count rows without limit.
		 *
		 * @return int
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function totalCount()
		{
			if ($this->total_count_cache === null) {
				$this->total_count_cache = $this->query->runTotalRowsCount(false);
			}

			return $this->total_count_cache;
		}

	}