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
 * Class OZFile.
 * 
 * @property-read string|null $id Getter for column `oz_files`.`id`.
 * @property-read string|null $owner_id Getter for column `oz_files`.`owner_id`.
 * @property-read string $key Getter for column `oz_files`.`key`.
 * @property-read string $ref Getter for column `oz_files`.`ref`.
 * @property-read string $driver Getter for column `oz_files`.`driver`.
 * @property-read string|null $clone_id Getter for column `oz_files`.`clone_id`.
 * @property-read string|null $source_id Getter for column `oz_files`.`source_id`.
 * @property-read int $size Getter for column `oz_files`.`size`.
 * @property-read string $mime_type Getter for column `oz_files`.`mime_type`.
 * @property-read string $extension Getter for column `oz_files`.`extension`.
 * @property-read string $name Getter for column `oz_files`.`name`.
 * @property-read string|null $for_id Getter for column `oz_files`.`for_id`.
 * @property-read string|null $for_type Getter for column `oz_files`.`for_type`.
 * @property-read string $for_label Getter for column `oz_files`.`for_label`.
 * @property-read array $data Getter for column `oz_files`.`data`.
 * @property-read string $created_at Getter for column `oz_files`.`created_at`.
 * @property-read string $updated_at Getter for column `oz_files`.`updated_at`.
 * @property-read bool $valid Getter for column `oz_files`.`valid`.
 */
abstract class OZFile extends \Gobl\ORM\ORMEntity
{
	public const TABLE_NAME = 'oz_files';
	public const TABLE_NAMESPACE = 'OZONE\\OZ\\Db';
	public const COL_ID = 'file_id';
	public const COL_OWNER_ID = 'file_owner_id';
	public const COL_KEY = 'file_key';
	public const COL_REF = 'file_ref';
	public const COL_DRIVER = 'file_driver';
	public const COL_CLONE_ID = 'file_clone_id';
	public const COL_SOURCE_ID = 'file_source_id';
	public const COL_SIZE = 'file_size';
	public const COL_MIME_TYPE = 'file_mime_type';
	public const COL_EXTENSION = 'file_extension';
	public const COL_NAME = 'file_name';
	public const COL_FOR_ID = 'file_for_id';
	public const COL_FOR_TYPE = 'file_for_type';
	public const COL_FOR_LABEL = 'file_for_label';
	public const COL_DATA = 'file_data';
	public const COL_CREATED_AT = 'file_created_at';
	public const COL_UPDATED_AT = 'file_updated_at';
	public const COL_VALID = 'file_valid';
	/**
	 * OZFile constructor.
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
		return new \OZONE\OZ\Db\OZFile($is_new, $strict);
	}

	/**
	 * Getter for column `oz_files`.`id`.
	 * 
	 * @return string|null
	 */
	public function getID(): string|null
	{
		return $this->{self::COL_ID};
	}

	/**
	 * Setter for column `oz_files`.`id`.
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
	 * Getter for column `oz_files`.`owner_id`.
	 * 
	 * @return string|null
	 */
	public function getOwnerID(): string|null
	{
		return $this->{self::COL_OWNER_ID};
	}

	/**
	 * Setter for column `oz_files`.`owner_id`.
	 * 
	 * @param string|int|null $owner_id
	 * 
	 * @return static
	 */
	public function setOwnerID(string|int|null $owner_id): static
	{
		$this->{self::COL_OWNER_ID} = $owner_id;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`key`.
	 * 
	 * @return string
	 */
	public function getKey(): string
	{
		return $this->{self::COL_KEY};
	}

	/**
	 * Setter for column `oz_files`.`key`.
	 * 
	 * @param string $key
	 * 
	 * @return static
	 */
	public function setKey(string $key): static
	{
		$this->{self::COL_KEY} = $key;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`ref`.
	 * 
	 * @return string
	 */
	public function getRef(): string
	{
		return $this->{self::COL_REF};
	}

	/**
	 * Setter for column `oz_files`.`ref`.
	 * 
	 * @param string $ref
	 * 
	 * @return static
	 */
	public function setRef(string $ref): static
	{
		$this->{self::COL_REF} = $ref;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`driver`.
	 * 
	 * @return string
	 */
	public function getDriver(): string
	{
		return $this->{self::COL_DRIVER};
	}

	/**
	 * Setter for column `oz_files`.`driver`.
	 * 
	 * @param string $driver
	 * 
	 * @return static
	 */
	public function setDriver(string $driver): static
	{
		$this->{self::COL_DRIVER} = $driver;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`clone_id`.
	 * 
	 * @return string|null
	 */
	public function getCloneID(): string|null
	{
		return $this->{self::COL_CLONE_ID};
	}

	/**
	 * Setter for column `oz_files`.`clone_id`.
	 * 
	 * @param string|int|null $clone_id
	 * 
	 * @return static
	 */
	public function setCloneID(string|int|null $clone_id): static
	{
		$this->{self::COL_CLONE_ID} = $clone_id;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`source_id`.
	 * 
	 * @return string|null
	 */
	public function getSourceID(): string|null
	{
		return $this->{self::COL_SOURCE_ID};
	}

	/**
	 * Setter for column `oz_files`.`source_id`.
	 * 
	 * @param string|int|null $source_id
	 * 
	 * @return static
	 */
	public function setSourceID(string|int|null $source_id): static
	{
		$this->{self::COL_SOURCE_ID} = $source_id;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`size`.
	 * 
	 * @return int
	 */
	public function getSize(): int
	{
		return $this->{self::COL_SIZE};
	}

	/**
	 * Setter for column `oz_files`.`size`.
	 * 
	 * @param int $size
	 * 
	 * @return static
	 */
	public function setSize(int $size): static
	{
		$this->{self::COL_SIZE} = $size;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`mime_type`.
	 * 
	 * @return string
	 */
	public function getMimeType(): string
	{
		return $this->{self::COL_MIME_TYPE};
	}

	/**
	 * Setter for column `oz_files`.`mime_type`.
	 * 
	 * @param string $mime_type
	 * 
	 * @return static
	 */
	public function setMimeType(string $mime_type): static
	{
		$this->{self::COL_MIME_TYPE} = $mime_type;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`extension`.
	 * 
	 * @return string
	 */
	public function getExtension(): string
	{
		return $this->{self::COL_EXTENSION};
	}

	/**
	 * Setter for column `oz_files`.`extension`.
	 * 
	 * @param string $extension
	 * 
	 * @return static
	 */
	public function setExtension(string $extension): static
	{
		$this->{self::COL_EXTENSION} = $extension;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`name`.
	 * 
	 * @return string
	 */
	public function getName(): string
	{
		return $this->{self::COL_NAME};
	}

	/**
	 * Setter for column `oz_files`.`name`.
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
	 * Getter for column `oz_files`.`for_id`.
	 * 
	 * @return string|null
	 */
	public function getForID(): string|null
	{
		return $this->{self::COL_FOR_ID};
	}

	/**
	 * Setter for column `oz_files`.`for_id`.
	 * 
	 * @param string|null $for_id
	 * 
	 * @return static
	 */
	public function setForID(string|null $for_id): static
	{
		$this->{self::COL_FOR_ID} = $for_id;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`for_type`.
	 * 
	 * @return string|null
	 */
	public function getForType(): string|null
	{
		return $this->{self::COL_FOR_TYPE};
	}

	/**
	 * Setter for column `oz_files`.`for_type`.
	 * 
	 * @param string|null $for_type
	 * 
	 * @return static
	 */
	public function setForType(string|null $for_type): static
	{
		$this->{self::COL_FOR_TYPE} = $for_type;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`for_label`.
	 * 
	 * @return string
	 */
	public function getForLabel(): string
	{
		return $this->{self::COL_FOR_LABEL};
	}

	/**
	 * Setter for column `oz_files`.`for_label`.
	 * 
	 * @param string $for_label
	 * 
	 * @return static
	 */
	public function setForLabel(string $for_label): static
	{
		$this->{self::COL_FOR_LABEL} = $for_label;

		return $this;
	}

	/**
	 * Getter for column `oz_files`.`data`.
	 * 
	 * @return array
	 */
	public function getData(): array
	{
		return $this->{self::COL_DATA};
	}

	/**
	 * Setter for column `oz_files`.`data`.
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
	 * Getter for column `oz_files`.`created_at`.
	 * 
	 * @return string
	 */
	public function getCreatedAT(): string
	{
		return $this->{self::COL_CREATED_AT};
	}

	/**
	 * Setter for column `oz_files`.`created_at`.
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
	 * Getter for column `oz_files`.`updated_at`.
	 * 
	 * @return string
	 */
	public function getUpdatedAT(): string
	{
		return $this->{self::COL_UPDATED_AT};
	}

	/**
	 * Setter for column `oz_files`.`updated_at`.
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
	 * Getter for column `oz_files`.`valid`.
	 * 
	 * @return bool
	 */
	public function getValid(): bool
	{
		return $this->{self::COL_VALID};
	}

	/**
	 * Setter for column `oz_files`.`valid`.
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
	 * ManyToOne relation between `oz_files` and `oz_users`.
	 * 
	 * @return ?\OZONE\OZ\Db\OZUser
	 */
	public function getOwner(): ?\OZONE\OZ\Db\OZUser
	{
		
		$filters_bundle = $this->buildRelationFilter([]);

		if (null === $filters_bundle) {
			return null;
		}

		return (new \OZONE\OZ\Db\OZUsersController())->getItem($filters_bundle);
	}

	/**
	 * OneToMany relation between `oz_files` and `oz_files`.
	 * 
	 * @param array    $filters  the row filters
	 * @param null|int $max      maximum row to retrieve
	 * @param int      $offset   first row offset
	 * @param array    $order_by order by rules
	 * @param null|int $total    total rows without limit
	 * 
	 * @return \OZONE\OZ\Db\OZFile[]
	 */
	public function getClones(array $filters = array (
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
	 * ManyToOne relation between `oz_files` and `oz_files`.
	 * 
	 * @return ?\OZONE\OZ\Db\OZFile
	 */
	public function getClonedFrom(): ?\OZONE\OZ\Db\OZFile
	{
		
		$filters_bundle = $this->buildRelationFilter([]);

		if (null === $filters_bundle) {
			return null;
		}

		return (new \OZONE\OZ\Db\OZFilesController())->getItem($filters_bundle);
	}

	/**
	 * ManyToOne relation between `oz_files` and `oz_files`.
	 * 
	 * @return ?\OZONE\OZ\Db\OZFile
	 */
	public function getSource(): ?\OZONE\OZ\Db\OZFile
	{
		
		$filters_bundle = $this->buildRelationFilter([]);

		if (null === $filters_bundle) {
			return null;
		}

		return (new \OZONE\OZ\Db\OZFilesController())->getItem($filters_bundle);
	}
}
