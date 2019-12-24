<?php
	/**
 * Auto generated file, please don't edit.
 *
 * With: Gobl v1.0.9
 * Time: 1577196385
 */


	namespace OZONE\OZ\Db\Base;

	use Gobl\DBAL\Db;
	use Gobl\DBAL\QueryBuilder;
	use Gobl\ORM\ORMResultsBase;

	/**
	 * Class OZCountriesResults
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZCountriesResults extends ORMResultsBase
	{
		/**
		 * OZCountriesResults constructor.
		 *
		 * @param \Gobl\DBAL\Db           $db
		 * @param \Gobl\DBAL\QueryBuilder $query
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function __construct(Db $db, QueryBuilder $query)
		{
			parent::__construct($db, $query, \OZONE\OZ\Db\OZCountry::class);
		}

		/**
		 * This is to help editor infer type in loop (foreach or for...)
		 *
		 * @return array|null|\OZONE\OZ\Db\OZCountry
		 */
		public function current()
		{
			return parent::current();
		}

		/**
		 * Fetches  the next row into table of the entity class instance.
		 *
		 * @param bool $strict
		 *
		 * @return null|\OZONE\OZ\Db\OZCountry
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function fetchClass($strict = true)
		{
			return parent::fetchClass($strict);
		}

		/**
		 * Fetches  all rows and return array of the entity class instance.
		 *
		 * @param bool $strict
		 *
		 * @return \OZONE\OZ\Db\OZCountry[]
		 * @throws \Gobl\DBAL\Exceptions\DBALException
		 */
		public function fetchAllClass($strict = true)
		{
			return parent::fetchAllClass($strict);
		}
	}