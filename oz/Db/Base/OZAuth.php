<?php
/**
 * Auto generated file
 * 
 * WARNING: please don't edit.
 * 
 * Proudly With: gobl v2.0.0
 * Time: 2023-03-31T23:29:45+00:00
 */
declare(strict_types=1);

namespace OZONE\OZ\Db\Base;

/**
 * Class OZAuth.
 * 
 * @property-read string $ref Getter for column `oz_auths`.`ref`.
 * @property-read string $label Getter for column `oz_auths`.`label`.
 * @property-read string $provider Getter for column `oz_auths`.`provider`.
 * @property-read string $refresh_key Getter for column `oz_auths`.`refresh_key`.
 * @property-read string $for Getter for column `oz_auths`.`for`.
 * @property-read string $code_hash Getter for column `oz_auths`.`code_hash`.
 * @property-read string $token_hash Getter for column `oz_auths`.`token_hash`.
 * @property-read string $state Getter for column `oz_auths`.`state`.
 * @property-read int $try_max Getter for column `oz_auths`.`try_max`.
 * @property-read int $try_count Getter for column `oz_auths`.`try_count`.
 * @property-read int $lifetime Getter for column `oz_auths`.`lifetime`.
 * @property-read string $expire Getter for column `oz_auths`.`expire`.
 * @property-read array $data Getter for column `oz_auths`.`data`.
 * @property-read string $created_at Getter for column `oz_auths`.`created_at`.
 * @property-read string $updated_at Getter for column `oz_auths`.`updated_at`.
 * @property-read bool $valid Getter for column `oz_auths`.`valid`.
 */
abstract class OZAuth extends \Gobl\ORM\ORMEntity
{
	public const TABLE_NAME = 'oz_auths';
	public const TABLE_NAMESPACE = 'OZONE\\OZ\\Db';
	public const COL_REF = 'auth_ref';
	public const COL_LABEL = 'auth_label';
	public const COL_PROVIDER = 'auth_provider';
	public const COL_REFRESH_KEY = 'auth_refresh_key';
	public const COL_FOR = 'auth_for';
	public const COL_CODE_HASH = 'auth_code_hash';
	public const COL_TOKEN_HASH = 'auth_token_hash';
	public const COL_STATE = 'auth_state';
	public const COL_TRY_MAX = 'auth_try_max';
	public const COL_TRY_COUNT = 'auth_try_count';
	public const COL_LIFETIME = 'auth_lifetime';
	public const COL_EXPIRE = 'auth_expire';
	public const COL_DATA = 'auth_data';
	public const COL_CREATED_AT = 'auth_created_at';
	public const COL_UPDATED_AT = 'auth_updated_at';
	public const COL_VALID = 'auth_valid';
	/**
	 * OZAuth constructor.
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
		return new \OZONE\OZ\Db\OZAuth($is_new, $strict);
	}

	/**
	 * Getter for column `oz_auths`.`ref`.
	 * 
	 * @return string
	 */
	public function getRef(): string
	{
		return $this->{self::COL_REF};
	}

	/**
	 * Setter for column `oz_auths`.`ref`.
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
	 * Getter for column `oz_auths`.`label`.
	 * 
	 * @return string
	 */
	public function getLabel(): string
	{
		return $this->{self::COL_LABEL};
	}

	/**
	 * Setter for column `oz_auths`.`label`.
	 * 
	 * @param string $label
	 * 
	 * @return static
	 */
	public function setLabel(string $label): static
	{
		$this->{self::COL_LABEL} = $label;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`provider`.
	 * 
	 * @return string
	 */
	public function getProvider(): string
	{
		return $this->{self::COL_PROVIDER};
	}

	/**
	 * Setter for column `oz_auths`.`provider`.
	 * 
	 * @param string $provider
	 * 
	 * @return static
	 */
	public function setProvider(string $provider): static
	{
		$this->{self::COL_PROVIDER} = $provider;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`refresh_key`.
	 * 
	 * @return string
	 */
	public function getRefreshKey(): string
	{
		return $this->{self::COL_REFRESH_KEY};
	}

	/**
	 * Setter for column `oz_auths`.`refresh_key`.
	 * 
	 * @param string $refresh_key
	 * 
	 * @return static
	 */
	public function setRefreshKey(string $refresh_key): static
	{
		$this->{self::COL_REFRESH_KEY} = $refresh_key;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`for`.
	 * 
	 * @return string
	 */
	public function getFor(): string
	{
		return $this->{self::COL_FOR};
	}

	/**
	 * Setter for column `oz_auths`.`for`.
	 * 
	 * @param string $for
	 * 
	 * @return static
	 */
	public function setFor(string $for): static
	{
		$this->{self::COL_FOR} = $for;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`code_hash`.
	 * 
	 * @return string
	 */
	public function getCodeHash(): string
	{
		return $this->{self::COL_CODE_HASH};
	}

	/**
	 * Setter for column `oz_auths`.`code_hash`.
	 * 
	 * @param string $code_hash
	 * 
	 * @return static
	 */
	public function setCodeHash(string $code_hash): static
	{
		$this->{self::COL_CODE_HASH} = $code_hash;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`token_hash`.
	 * 
	 * @return string
	 */
	public function getTokenHash(): string
	{
		return $this->{self::COL_TOKEN_HASH};
	}

	/**
	 * Setter for column `oz_auths`.`token_hash`.
	 * 
	 * @param string $token_hash
	 * 
	 * @return static
	 */
	public function setTokenHash(string $token_hash): static
	{
		$this->{self::COL_TOKEN_HASH} = $token_hash;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`state`.
	 * 
	 * @return string
	 */
	public function getState(): string
	{
		return $this->{self::COL_STATE};
	}

	/**
	 * Setter for column `oz_auths`.`state`.
	 * 
	 * @param string $state
	 * 
	 * @return static
	 */
	public function setState(string $state): static
	{
		$this->{self::COL_STATE} = $state;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`try_max`.
	 * 
	 * @return int
	 */
	public function getTryMax(): int
	{
		return $this->{self::COL_TRY_MAX};
	}

	/**
	 * Setter for column `oz_auths`.`try_max`.
	 * 
	 * @param int $try_max
	 * 
	 * @return static
	 */
	public function setTryMax(int $try_max): static
	{
		$this->{self::COL_TRY_MAX} = $try_max;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`try_count`.
	 * 
	 * @return int
	 */
	public function getTryCount(): int
	{
		return $this->{self::COL_TRY_COUNT};
	}

	/**
	 * Setter for column `oz_auths`.`try_count`.
	 * 
	 * @param int $try_count
	 * 
	 * @return static
	 */
	public function setTryCount(int $try_count): static
	{
		$this->{self::COL_TRY_COUNT} = $try_count;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`lifetime`.
	 * 
	 * @return int
	 */
	public function getLifetime(): int
	{
		return $this->{self::COL_LIFETIME};
	}

	/**
	 * Setter for column `oz_auths`.`lifetime`.
	 * 
	 * @param int $lifetime
	 * 
	 * @return static
	 */
	public function setLifetime(int $lifetime): static
	{
		$this->{self::COL_LIFETIME} = $lifetime;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`expire`.
	 * 
	 * @return string
	 */
	public function getExpire(): string
	{
		return $this->{self::COL_EXPIRE};
	}

	/**
	 * Setter for column `oz_auths`.`expire`.
	 * 
	 * @param string|int $expire
	 * 
	 * @return static
	 */
	public function setExpire(string|int $expire): static
	{
		$this->{self::COL_EXPIRE} = $expire;

		return $this;
	}

	/**
	 * Getter for column `oz_auths`.`data`.
	 * 
	 * @return array
	 */
	public function getData(): array
	{
		return $this->{self::COL_DATA};
	}

	/**
	 * Setter for column `oz_auths`.`data`.
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
	 * Getter for column `oz_auths`.`created_at`.
	 * 
	 * @return string
	 */
	public function getCreatedAT(): string
	{
		return $this->{self::COL_CREATED_AT};
	}

	/**
	 * Setter for column `oz_auths`.`created_at`.
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
	 * Getter for column `oz_auths`.`updated_at`.
	 * 
	 * @return string
	 */
	public function getUpdatedAT(): string
	{
		return $this->{self::COL_UPDATED_AT};
	}

	/**
	 * Setter for column `oz_auths`.`updated_at`.
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
	 * Getter for column `oz_auths`.`valid`.
	 * 
	 * @return bool
	 */
	public function getValid(): bool
	{
		return $this->{self::COL_VALID};
	}

	/**
	 * Setter for column `oz_auths`.`valid`.
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
}
