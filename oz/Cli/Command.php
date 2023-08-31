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

namespace OZONE\Core\Cli;

use Kli\KliAction;
use Kli\KliArgs;
use Kli\KliCommand;

/**
 * Class Command.
 */
abstract class Command extends KliCommand
{
	/**
	 * Command constructor.
	 *
	 * @param string              $name command name
	 * @param \OZONE\Core\Cli\Cli $cli  cli object to use
	 *
	 * @throws \Kli\Exceptions\KliException
	 */
	protected function __construct(string $name, Cli $cli)
	{
		parent::__construct($name, $cli);
		$this->describe();
	}

	/**
	 * Should return a new instance.
	 *
	 * @param string              $name
	 * @param \OZONE\Core\Cli\Cli $cli
	 *
	 * @return self
	 *
	 * @throws \Kli\Exceptions\KliException
	 */
	public static function instance(string $name, Cli $cli): self
	{
		return new static($name, $cli);
	}

	/**
	 * {@inheritDoc}
	 */
	public function execute(KliAction $action, KliArgs $args): void
	{
	}

	/**
	 * Describe your command.
	 *
	 * Is called once the cli start.
	 * You can add Actions and Options to your command here.
	 */
	abstract protected function describe();
}
