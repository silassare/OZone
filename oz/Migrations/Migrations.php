<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace OZONE\Core\Migrations;

use Gobl\DBAL\Db as GoblDb;
use Gobl\DBAL\Diff\Diff;
use Gobl\DBAL\Interfaces\MigrationInterface;
use OZONE\Core\App\Db;
use OZONE\Core\App\Settings;
use OZONE\Core\Cache\CacheManager;
use OZONE\Core\Exceptions\RuntimeException;
use OZONE\Core\Utils\Random;

/**
 * Class Migrations.
 */
final class Migrations
{
	public const DB_NOT_INSTALLED_VERSION = 0;
	public const FIRST_VERSION            = 1;

	/**
	 * Migrations constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Gets the current database version.
	 *
	 * @return int
	 */
	public static function getCurrentDbVersion(): int
	{
		return Settings::get('oz.db.migrations', 'OZ_MIGRATION_VERSION', self::DB_NOT_INSTALLED_VERSION);
	}

	/**
	 * Runs a given migration.
	 *
	 * @param \Gobl\DBAL\Interfaces\MigrationInterface $migration
	 */
	public function run(MigrationInterface $migration): void
	{
		$query = $migration->up();
		if ($query) {
			db()->executeMulti($query);

			$this->setCurrentDbVersion($migration->getVersion());
		}
	}

	/**
	 * Rolls back a given migration.
	 *
	 * @param \Gobl\DBAL\Interfaces\MigrationInterface $migration
	 */
	public function rollbackMigration(MigrationInterface $migration): void
	{
		$query = $migration->down();
		if ($query) {
			db()->executeMulti($query);

			$version  = self::DB_NOT_INSTALLED_VERSION;
			$previous = $this->getPreviousMigration($migration->getVersion());

			if ($previous) {
				$version = $previous->getVersion();
			}

			$this->setCurrentDbVersion($version);
		}
	}

	/**
	 * Create a new migration.
	 *
	 * @return null|string
	 */
	public function create(): ?string
	{
		$fm        = app()->getMigrationsDir();
		$latest    = $this->getLatestMigration();
		$db_actual = db();
		$config    = $db_actual->getConfig();

		$db_from = GoblDb::createInstanceOf($db_actual->getType(), $config);
		$db_to   = GoblDb::createInstanceOf($db_actual->getType(), $config);

		Db::loadSchemaTo($db_to);
		$db_to->lock();

		if ($latest) {
			$db_from->ns('Migrations')
				->schema($latest->getSchema());
			$version = $latest->getVersion() + 1;
		} else {
			$version = self::FIRST_VERSION;
		}

		$diff = new Diff($db_from, $db_to);

		if ($diff->hasChanges()) {
			$outfile = $fm->resolve(\sprintf('%s.php', Random::fileName('migration')));
			$fm->wf($outfile, (string) $diff->generateMigrationFile($version));

			return $outfile;
		}

		return null;
	}

	/**
	 * Gets all migrations.
	 *
	 * @return array
	 */
	public function migrations(): array
	{
		$cm = CacheManager::runtime(self::class);

		return $cm->factory('migrations', function () {
			$fm = app()->getMigrationsDir();

			$filter     = $fm->filter()
				->isFile()
				->isReadable()
				->name('#\.php$#');
			$migrations = [];

			$duplicates = [];

			foreach ($filter->find() as $file) {
				$migration = require $file;

				if ($migration instanceof MigrationInterface) {
					$version = $migration->getVersion();

					if (isset($duplicates[$version])) {
						throw new RuntimeException(\sprintf(
							'Duplicate migration version "%s" found in "%s" and "%s"',
							$version,
							$duplicates[$version],
							$file
						));
					}

					$duplicates[$migration->getVersion()] = $file;
					$migrations[]                         = $migration;
				} else {
					throw new RuntimeException(\sprintf(
						'Invalid migration file "%s", it must return an instance of "%s" not "%s"',
						$file,
						MigrationInterface::class,
						\get_debug_type($migration),
					));
				}
			}

			\usort($migrations, static fn (MigrationInterface $a, MigrationInterface $b) => $a->getVersion() <=> $b->getVersion());

			return $migrations;
		})
			->get();
	}

	/**
	 * Gets the latest migration.
	 *
	 * @return null|\Gobl\DBAL\Interfaces\MigrationInterface
	 */
	public function getLatestMigration(): ?MigrationInterface
	{
		$migrations = $this->migrations();
		$latest     = \end($migrations);

		return $latest instanceof MigrationInterface ? $latest : null;
	}

	/**
	 * Checks if there are pending migrations.
	 *
	 * @return bool
	 */
	public function hasPendingMigrations(): bool
	{
		$latest = $this->getLatestMigration();
		if ($latest) {
			return self::getCurrentDbVersion() < $latest->getVersion();
		}

		return false;
	}

	/**
	 * Gets the pending migrations.
	 *
	 * @return MigrationInterface[]
	 */
	public function getPendingMigrations(): array
	{
		$pending         = [];
		$current_version = self::getCurrentDbVersion();
		$migrations      = $this->migrations();

		foreach ($migrations as $migration) {
			if ($migration->getVersion() > $current_version) {
				$pending[] = $migration;
			}
		}

		return $pending;
	}

	/**
	 * Gets a migration by its version.
	 *
	 * @param int $version
	 *
	 * @return null|\Gobl\DBAL\Interfaces\MigrationInterface
	 */
	public function getMigration(int $version): ?MigrationInterface
	{
		$migrations = $this->migrations();

		foreach ($migrations as $migration) {
			if ($migration->getVersion() === $version) {
				return $migration;
			}
		}

		return null;
	}

	/**
	 * Gets the previous migration.
	 *
	 * @param int $version
	 *
	 * @return null|\Gobl\DBAL\Interfaces\MigrationInterface
	 */
	public function getPreviousMigration(int $version): ?MigrationInterface
	{
		$migrations = $this->migrations();
		$previous   = null;

		foreach ($migrations as $migration) {
			if ($migration->getVersion() === $version) {
				return $previous;
			}

			$previous = $migration;
		}

		return null;
	}

	/**
	 * Gets the migrations between two versions.
	 *
	 * @param int $from_version
	 * @param int $to_version
	 *
	 * @return MigrationInterface[]
	 */
	public function getMigrationBetween(int $from_version, int $to_version): array
	{
		$migrations = $this->migrations();
		$between    = [];

		foreach ($migrations as $migration) {
			if ($migration->getVersion() >= $from_version && $migration->getVersion() <= $to_version) {
				$between[] = $migration;
			}
		}

		return $between;
	}

	/**
	 * Gets the next migration.
	 *
	 * @param int $version
	 *
	 * @return null|\Gobl\DBAL\Interfaces\MigrationInterface
	 */
	public function getNextMigration(int $version): ?MigrationInterface
	{
		$migrations = $this->migrations();
		$next       = null;

		foreach ($migrations as $migration) {
			if ($next) {
				return $migration;
			}

			if ($migration->getVersion() === $version) {
				$next = $migration;
			}
		}

		return null;
	}

	/**
	 * Sets the current database version.
	 *
	 * @param int $version
	 */
	private function setCurrentDbVersion(int $version): void
	{
		Settings::set('oz.db.migrations', 'OZ_MIGRATION_VERSION', $version);
	}
}