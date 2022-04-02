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

use OZONE\OZ\Cli\Cmd\Client;
use OZONE\OZ\Cli\Cmd\Db;
use OZONE\OZ\Cli\Cmd\Project;
use OZONE\OZ\Cli\Cmd\Service;

return [
	'project' => Project::class,
	'client'  => Client::class,
	'db'      => Db::class,
	'service' => Service::class,
];
