<?php
/**
 * Auto generated file
 * 
 * WARNING: please don't edit.
 * 
 * Proudly With: gobl v2.0.0
 * Time: 2023-05-06T15:46:01+00:00
 */
declare(strict_types=1);

namespace OZONE\OZ\Db\Base;

/**
 * Class OZUser.
 * 
 * @property-read string|null $id Getter for column `oz_users`.`id`.
 * @property-read string|null $phone Getter for column `oz_users`.`phone`.
 * @property-read string $email Getter for column `oz_users`.`email`.
 * @property-read string $pass Getter for column `oz_users`.`pass`.
 * @property-read string $name Getter for column `oz_users`.`name`.
 * @property-read string $gender Getter for column `oz_users`.`gender`.
 * @property-read string $birth_date Getter for column `oz_users`.`birth_date`.
 * @property-read string|null $pic Getter for column `oz_users`.`pic`.
 * @property-read string $cc2 Getter for column `oz_users`.`cc2`.
 * @property-read array $data Getter for column `oz_users`.`data`.
 * @property-read string $created_at Getter for column `oz_users`.`created_at`.
 * @property-read string $updated_at Getter for column `oz_users`.`updated_at`.
 * @property-read bool $valid Getter for column `oz_users`.`valid`.
 */
abstract class OZUser extends \Gobl\ORM\ORMEntity
{
	public const TABLE_NAME = 'oz_users';
	public const TABLE_NAMESPACE = 'OZONE\\OZ\\Db';
	public const COL_ID = 'user_id';
	public const COL_PHONE = 'user_phone';
	public const COL_EMAIL = 'user_email';
	public const COL_PASS = 'user_pass';
	public const COL_NAME = 'user_name';
	public const COL_GENDER = 'user_gender';
	public const COL_BIRTH_DATE = 'user_birth_date';
	public const COL_PIC = 'user_pic';
	public const COL_CC2 = 'user_cc2';
	public const COL_DATA = 'user_data';
	public const COL_CREATED_AT = 'user_created_at';
	public const COL_UPDATED_AT = 'user_updated_at';
	public const COL_VALID = 'user_valid';
	/**
	 * OZUser constructor.
	 * 
	 * @param bool $is_new true for new entity false for entity fetched
	 *                      from the database, default is true
	 * @param bool $strict Enable/disable strict mode
	 */
	public function __construct(bool $is_new = true, bool $strict = true)
	{
		parent::__construct(
			self::TABLE_NAMESPACE,
			self::TABLE_NAME,
			$is_new,
			$strict
		);

	}

	/**
	 * @inheritDoc
	 * 
	 * @return static
	 */
	public static function createInstance(bool $is_new = true, bool $strict = true): static
	{
		return new \OZONE\OZ\Db\OZUser($is_new, $strict);
	}

	/**
	 * Getter for column `oz_users`.`id`.
	 * 
	 * @return string|null
	 */
	public function getID(): string|null
	{
		return $this->{self::COL_ID};
	}

	/**
	 * Setter for column `oz_users`.`id`.
	 * 
	 * @param string|int|null $id
	 * 
	 * @return static
	 */
	public function setID(string|int|null $id): static
	{
		$this->{self::COL_ID} = $id;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`phone`.
	 * 
	 * @return string|null
	 */
	public function getPhone(): string|null
	{
		return $this->{self::COL_PHONE};
	}

	/**
	 * Setter for column `oz_users`.`phone`.
	 * 
	 * @param string|null $phone
	 * 
	 * @return static
	 */
	public function setPhone(string|null $phone): static
	{
		$this->{self::COL_PHONE} = $phone;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`email`.
	 * 
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->{self::COL_EMAIL};
	}

	/**
	 * Setter for column `oz_users`.`email`.
	 * 
	 * @param string $email
	 * 
	 * @return static
	 */
	public function setEmail(string $email): static
	{
		$this->{self::COL_EMAIL} = $email;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`pass`.
	 * 
	 * @return string
	 */
	public function getPass(): string
	{
		return $this->{self::COL_PASS};
	}

	/**
	 * Setter for column `oz_users`.`pass`.
	 * 
	 * @param string $pass
	 * 
	 * @return static
	 */
	public function setPass(string $pass): static
	{
		$this->{self::COL_PASS} = $pass;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`name`.
	 * 
	 * @return string
	 */
	public function getName(): string
	{
		return $this->{self::COL_NAME};
	}

	/**
	 * Setter for column `oz_users`.`name`.
	 * 
	 * @param string $name
	 * 
	 * @return static
	 */
	public function setName(string $name): static
	{
		$this->{self::COL_NAME} = $name;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`gender`.
	 * 
	 * @return string
	 */
	public function getGender(): string
	{
		return $this->{self::COL_GENDER};
	}

	/**
	 * Setter for column `oz_users`.`gender`.
	 * 
	 * @param string $gender
	 * 
	 * @return static
	 */
	public function setGender(string $gender): static
	{
		$this->{self::COL_GENDER} = $gender;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`birth_date`.
	 * 
	 * @return string
	 */
	public function getBirthDate(): string
	{
		return $this->{self::COL_BIRTH_DATE};
	}

	/**
	 * Setter for column `oz_users`.`birth_date`.
	 * 
	 * @param string|int $birth_date
	 * 
	 * @return static
	 */
	public function setBirthDate(string|int $birth_date): static
	{
		$this->{self::COL_BIRTH_DATE} = $birth_date;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`pic`.
	 * 
	 * @return string|null
	 */
	public function getPic(): string|null
	{
		return $this->{self::COL_PIC};
	}

	/**
	 * Setter for column `oz_users`.`pic`.
	 * 
	 * @param string|null $pic
	 * 
	 * @return static
	 */
	public function setPic(string|null $pic): static
	{
		$this->{self::COL_PIC} = $pic;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`cc2`.
	 * 
	 * @return string
	 */
	public function getCc2(): string
	{
		return $this->{self::COL_CC2};
	}

	/**
	 * Setter for column `oz_users`.`cc2`.
	 * 
	 * @param string $cc2
	 * 
	 * @return static
	 */
	public function setCc2(string $cc2): static
	{
		$this->{self::COL_CC2} = $cc2;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`data`.
	 * 
	 * @return array
	 */
	public function getData(): array
	{
		return $this->{self::COL_DATA};
	}

	/**
	 * Setter for column `oz_users`.`data`.
	 * 
	 * @param array $data
	 * 
	 * @return static
	 */
	public function setData(array $data): static
	{
		$this->{self::COL_DATA} = $data;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`created_at`.
	 * 
	 * @return string
	 */
	public function getCreatedAT(): string
	{
		return $this->{self::COL_CREATED_AT};
	}

	/**
	 * Setter for column `oz_users`.`created_at`.
	 * 
	 * @param string|int $created_at
	 * 
	 * @return static
	 */
	public function setCreatedAT(string|int $created_at): static
	{
		$this->{self::COL_CREATED_AT} = $created_at;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`updated_at`.
	 * 
	 * @return string
	 */
	public function getUpdatedAT(): string
	{
		return $this->{self::COL_UPDATED_AT};
	}

	/**
	 * Setter for column `oz_users`.`updated_at`.
	 * 
	 * @param string|int $updated_at
	 * 
	 * @return static
	 */
	public function setUpdatedAT(string|int $updated_at): static
	{
		$this->{self::COL_UPDATED_AT} = $updated_at;

		return $this;
	}

	/**
	 * Getter for column `oz_users`.`valid`.
	 * 
	 * @return bool
	 */
	public function getValid(): bool
	{
		return $this->{self::COL_VALID};
	}

	/**
	 * Setter for column `oz_users`.`valid`.
	 * 
	 * @param bool $valid
	 * 
	 * @return static
	 */
	public function setValid(bool $valid): static
	{
		$this->{self::COL_VALID} = $valid;

		return $this;
	}

	/**
	 * OneToMany relation between `oz_users` and `oz_files`.
	 * 
	 * @param array    $filters  the row filters
	 * @param null|int $max      maximum row to retrieve
	 * @param int      $offset   first row offset
	 * @param array    $order_by order by rules
	 * @param null|int $total    total rows without limit
	 * 
	 * @return \OZONE\OZ\Db\OZFile[]
	 */
	public function getFiles(array $filters = array (
	), ?int $max = NULL, int $offset = 0, array $order_by = array (
	), ?int &$total = -1): array
	{
		
		$filters_bundle = $this->buildRelationFilter($getters, $filters);

		if (null === $filters_bundle) {
			return [];
		}

		return (new \OZONE\OZ\Db\OZFilesController())->getAllItems($filters_bundle, $max, $offset, $order_by, $total);
	}

	/**
	 * OneToOne relation between `oz_users` and `oz_countries`.
	 * 
	 * @return ?\OZONE\OZ\Db\OZCountry
	 */
	public function getCountry(): ?\OZONE\OZ\Db\OZCountry
	{
		
		$filters_bundle = $this->buildRelationFilter([]);

		if (null === $filters_bundle) {
			return null;
		}

		return (new \OZONE\OZ\Db\OZCountriesController())->getItem($filters_bundle);
	}

	/**
	 * OneToMany relation between `oz_users` and `oz_sessions`.
	 * 
	 * @param array    $filters  the row filters
	 * @param null|int $max      maximum row to retrieve
	 * @param int      $offset   first row offset
	 * @param array    $order_by order by rules
	 * @param null|int $total    total rows without limit
	 * 
	 * @return \OZONE\OZ\Db\OZSession[]
	 */
	public function getSessions(array $filters = array (
	), ?int $max = NULL, int $offset = 0, array $order_by = array (
	), ?int &$total = -1): array
	{
		
		$filters_bundle = $this->buildRelationFilter($getters, $filters);

		if (null === $filters_bundle) {
			return [];
		}

		return (new \OZONE\OZ\Db\OZSessionsController())->getAllItems($filters_bundle, $max, $offset, $order_by, $total);
	}

	/**
	 * OneToMany relation between `oz_users` and `oz_clients`.
	 * 
	 * @param array    $filters  the row filters
	 * @param null|int $max      maximum row to retrieve
	 * @param int      $offset   first row offset
	 * @param array    $order_by order by rules
	 * @param null|int $total    total rows without limit
	 * 
	 * @return \OZONE\OZ\Db\OZClient[]
	 */
	public function getAttachedClients(array $filters = array (
	), ?int $max = NULL, int $offset = 0, array $order_by = array (
	), ?int &$total = -1): array
	{
		
		$filters_bundle = $this->buildRelationFilter($getters, $filters);

		if (null === $filters_bundle) {
			return [];
		}

		return (new \OZONE\OZ\Db\OZClientsController())->getAllItems($filters_bundle, $max, $offset, $order_by, $total);
	}

	/**
	 * OneToMany relation between `oz_users` and `oz_clients`.
	 * 
	 * @param array    $filters  the row filters
	 * @param null|int $max      maximum row to retrieve
	 * @param int      $offset   first row offset
	 * @param array    $order_by order by rules
	 * @param null|int $total    total rows without limit
	 * 
	 * @return \OZONE\OZ\Db\OZClient[]
	 */
	public function getOwnedClients(array $filters = array (
	), ?int $max = NULL, int $offset = 0, array $order_by = array (
	), ?int &$total = -1): array
	{
		
		$filters_bundle = $this->buildRelationFilter($getters, $filters);

		if (null === $filters_bundle) {
			return [];
		}

		return (new \OZONE\OZ\Db\OZClientsController())->getAllItems($filters_bundle, $max, $offset, $order_by, $total);
	}
}
