<?php
	/**
	 * Auto generated file, please don't edit.
	 *
	 * With: Gobl v1.0.0
	 * Time: 1509638392
	 */

	namespace OZONE\OZ\Db\Base;

	use Gobl\DBAL\QueryBuilder;
	use Gobl\ORM\ArrayCapable;
	use Gobl\ORM\Exceptions\ORMException;
	use Gobl\ORM\ORM;
	use OZONE\OZ\Db\OZUsersQuery as OZUsersQueryReal;

	use OZONE\OZ\Db\OZFilesQuery;
	use OZONE\OZ\Db\OZCountriesQuery;


	/**
	 * Class OZUser
	 *
	 * @package OZONE\OZ\Db\Base
	 */
	abstract class OZUser extends ArrayCapable
	{
		const COL_ID = 'user_id';
		const COL_PHONE = 'user_phone';
		const COL_EMAIL = 'user_email';
		const COL_PASS = 'user_pass';
		const COL_NAME = 'user_name';
		const COL_GENDER = 'user_gender';
		const COL_BIRTH_DATE = 'user_birth_date';
		const COL_SIGN_UP_TIME = 'user_sign_up_time';
		const COL_PICID = 'user_picid';
		const COL_CC2 = 'user_cc2';
		const COL_VALID = 'user_valid';

		/** @var \Gobl\DBAL\Table */
		protected $table;

		/** @var  array */
		protected $row;

		/** @var  array */
		protected $row_saved;

		/**
		 * @var bool
		 */
		protected $is_new = true;

		/**
		 * @var bool
		 */
		protected $saved = false;

		/**
		 * @var bool
		 */
		protected $modified = false;

		/**
		 * The auto_increment column full name.
		 *
		 * @var string
		 */
		protected $auto_increment_column = null;


		/**
		 * @var \OZONE\OZ\Db\OZCountry
		 */
		protected $r_OZ_country;


		/**
		 * OZUser constructor.
		 *
		 * @param bool $is_new True for new entity false for entity fetched
		 *                     from the database, default is true.
		 */
		public function __construct($is_new = true)
		{
			$this->table  = ORM::getDatabase()
							   ->getTable('oz_users');
			$columns      = $this->table->getColumns();
			$this->is_new = (bool)$is_new;

			// we initialise row with default value
			foreach ($columns as $column) {
				$full_name             = $column->getFullName();
				$this->row[$full_name] = $column->getDefaultValue();

				// the auto_increment column
				if ($column->isAutoIncrement()) {
					$this->auto_increment_column = $full_name;
				}
			}
		}

        /**
         * OneToMany relation between `oz_users` and `oz_files`.
         *
		 * @param null|int $max    maximum row to retrieve
		 * @param int      $offset first row offset
		 *
         * @return \OZONE\OZ\Db\OZFile[]
         */
        public function getOZFiles($max = null, $offset = 0)
        {
            $m = new OZFilesQuery();

            $m->filterByUserId($this->getId());

            return $m->find($max, $offset)->fetchAllClass();
        }

        /**
         * OneToOne relation between `oz_users` and `oz_countries`.
         *
         * @return null|\OZONE\OZ\Db\OZCountry
         */
        public function getOZCountry()
        {
            if (!isset($this->r_OZ_country)) {
                $m = new OZCountriesQuery();

                $m->filterByCc2($this->getCc2());

                $this->r_OZ_country = $m->find()->fetchClass();
            }

            return $this->r_OZ_country;
        }


		/**
		 * Getter for column `oz_users`.`id`.
		 *
		 * @return string the real type is: bigint
		 */
		public function getId()
		{
		    $v = $this->_getValue(self::COL_ID);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`id`.
		 *
		 * @param string $id
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setId($id)
		{
			return $this->_setValue(self::COL_ID, $id);
		}

		/**
		 * Getter for column `oz_users`.`phone`.
		 *
		 * @return string the real type is: string
		 */
		public function getPhone()
		{
		    $v = $this->_getValue(self::COL_PHONE);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`phone`.
		 *
		 * @param string $phone
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setPhone($phone)
		{
			return $this->_setValue(self::COL_PHONE, $phone);
		}

		/**
		 * Getter for column `oz_users`.`email`.
		 *
		 * @return string the real type is: string
		 */
		public function getEmail()
		{
		    $v = $this->_getValue(self::COL_EMAIL);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`email`.
		 *
		 * @param string $email
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setEmail($email)
		{
			return $this->_setValue(self::COL_EMAIL, $email);
		}

		/**
		 * Getter for column `oz_users`.`pass`.
		 *
		 * @return string the real type is: string
		 */
		public function getPass()
		{
		    $v = $this->_getValue(self::COL_PASS);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`pass`.
		 *
		 * @param string $pass
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setPass($pass)
		{
			return $this->_setValue(self::COL_PASS, $pass);
		}

		/**
		 * Getter for column `oz_users`.`name`.
		 *
		 * @return string the real type is: string
		 */
		public function getName()
		{
		    $v = $this->_getValue(self::COL_NAME);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`name`.
		 *
		 * @param string $name
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setName($name)
		{
			return $this->_setValue(self::COL_NAME, $name);
		}

		/**
		 * Getter for column `oz_users`.`gender`.
		 *
		 * @return string the real type is: string
		 */
		public function getGender()
		{
		    $v = $this->_getValue(self::COL_GENDER);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`gender`.
		 *
		 * @param string $gender
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setGender($gender)
		{
			return $this->_setValue(self::COL_GENDER, $gender);
		}

		/**
		 * Getter for column `oz_users`.`birth_date`.
		 *
		 * @return string the real type is: string
		 */
		public function getBirthDate()
		{
		    $v = $this->_getValue(self::COL_BIRTH_DATE);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`birth_date`.
		 *
		 * @param string $birth_date
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setBirthDate($birth_date)
		{
			return $this->_setValue(self::COL_BIRTH_DATE, $birth_date);
		}

		/**
		 * Getter for column `oz_users`.`sign_up_time`.
		 *
		 * @return string the real type is: bigint
		 */
		public function getSignUpTime()
		{
		    $v = $this->_getValue(self::COL_SIGN_UP_TIME);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`sign_up_time`.
		 *
		 * @param string $sign_up_time
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setSignUpTime($sign_up_time)
		{
			return $this->_setValue(self::COL_SIGN_UP_TIME, $sign_up_time);
		}

		/**
		 * Getter for column `oz_users`.`picid`.
		 *
		 * @return string the real type is: string
		 */
		public function getPicid()
		{
		    $v = $this->_getValue(self::COL_PICID);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`picid`.
		 *
		 * @param string $picid
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setPicid($picid)
		{
			return $this->_setValue(self::COL_PICID, $picid);
		}

		/**
		 * Getter for column `oz_users`.`cc2`.
		 *
		 * @return string the real type is: string
		 */
		public function getCc2()
		{
		    $v = $this->_getValue(self::COL_CC2);

		    if( $v !== null){
		        $v = (string)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`cc2`.
		 *
		 * @param string $cc2
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setCc2($cc2)
		{
			return $this->_setValue(self::COL_CC2, $cc2);
		}

		/**
		 * Getter for column `oz_users`.`valid`.
		 *
		 * @return bool the real type is: bool
		 */
		public function getValid()
		{
		    $v = $this->_getValue(self::COL_VALID);

		    if( $v !== null){
		        $v = (bool)$v;
		    }

			return $v;
		}

		/**
		 * Setter for column `oz_users`.`valid`.
		 *
		 * @param bool $valid
		 *
		 * @return \OZONE\OZ\Db\OZUser
		 */
		public function setValid($valid)
		{
			return $this->_setValue(self::COL_VALID, $valid);
		}

		/**
		 * Hydrate, load, populate this entity with values from an array.
		 *
		 * @param array $row map column name to column value
		 *
		 * @return $this|\OZONE\OZ\Db\OZUser
		 */
		public function hydrate(array $row)
		{
			foreach ($row as $column_name => $value) {
				$this->_setValue($column_name, $value);
			}

			return $this;
		}

		/**
		 * To check if this entity is modified
		 *
		 * @return bool
		 */
		public function isModified()
		{
			return $this->modified;
		}

		/**
		 * To check if this entity is new
		 *
		 * @return bool
		 */
		public function isNew()
		{
			return $this->is_new;
		}

		/**
		 * To check if this entity is saved
		 *
		 * @return bool
		 */
		public function isSaved()
		{
			return $this->saved;
		}

		/**
		 * Saves modifications to database.
		 *
		 * @return int|string int for affected row count on update, string for last insert id
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function save()
		{
			if ($this->isSaved()) {
				if ($this->isModified()) {
					// update
					$t       = new OZUsersQueryReal();
					$returns = $t->safeUpdate($this->row_saved, $this->row);
				} else {
					$returns = 0;
				}
			} else {
				// add
				$columns = array_keys($this->row);
				$values  = array_values($this->row);
				$qb      = new QueryBuilder(ORM::getDatabase());
				$qb->insert()
				   ->into($this->table->getFullName(), $columns)
				   ->values($values);

				$result    = $qb->execute();
				$ai_column = $this->auto_increment_column;

				if (!empty($ai_column)) {
					if (is_string($result)) {
						$this->row[$ai_column] = $result;
						$returns               = $result; // last insert id
					} else {
						throw new ORMException(sprintf('Unable to get last insert id for column "%s" in table "%s"', $ai_column, $this->table->getName()));
					}
				} else {
					$returns = intval($result); // one row saved
				}
			}

			$this->row_saved = $this->row;
			$this->is_new    = false;
			$this->saved     = true;
			$this->modified  = false;

			return $returns;
		}

		/**
		 * Gets a column value.
		 *
		 * @param string $name the column name or full name.
		 *
		 * @return mixed
		 */
		protected function _getValue($name)
		{
			if ($this->table->hasColumn($name)) {
				$column    = $this->table->getColumn($name);
				$full_name = $column->getFullName();

				return $this->row[$full_name];
			}

			return null;
		}

		/**
		 * Sets a column value.
		 *
		 * @param string $name  the column name or full name.
		 * @param mixed  $value the column new value.
		 *
		 * @return $this|\OZONE\OZ\Db\OZUser
		 */
		protected function _setValue($name, $value)
		{
			if ($this->table->hasColumn($name)) {
				$column    = $this->table->getColumn($name);
				$value     = $column->getTypeObject()
									->validate($value);
				$full_name = $column->getFullName();
				if ($this->row[$full_name] !== $value) {
					$this->row[$full_name] = $value;
					$this->modified        = true;
					$this->saved           = false;
				}
			}

			return $this;
		}

		/**
		 * Magic setter for row fetched as class.
		 *
		 * @param string $full_name the column full name
		 * @param mixed  $value     the column value
		 *
		 * @throws \Gobl\ORM\Exceptions\ORMException
		 */
		public function __set($full_name, $value)
		{
			if (!$this->isNew()) {
				if ($this->table->hasColumn($full_name)) {
					$this->row[$full_name]       = $value;
					$this->row_saved[$full_name] = $value;
					$this->modified              = false;
				} else {
					throw new ORMException(sprintf('Could not set column "%s", not defined in table "%s".', $full_name, $this->table->getName()));
				}
			} else {
				throw new ORMException(sprintf('You should not try to manually set property for "%s".', $full_name, get_class($this)));
			}
		}

		/**
		 * {@inheritdoc}
		 */
		public function asArray()
		{
			return $this->row;
		}
	}