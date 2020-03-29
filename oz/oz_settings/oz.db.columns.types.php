<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone (O'Zone) package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
	
	\defined('OZ_SELF_SECURITY_CHECK') || die;

	return [
		'phone'     => '\OZONE\OZ\Columns\Types\TypePhone',
		'email'     => '\OZONE\OZ\Columns\Types\TypeEmail',
		'date'      => '\OZONE\OZ\Columns\Types\TypeDate',
		'user_name' => '\OZONE\OZ\Columns\Types\TypeUserName',
		'password'  => '\OZONE\OZ\Columns\Types\TypePassword',
		'cc2'       => '\OZONE\OZ\Columns\Types\TypeCC2',
		'gender'    => '\OZONE\OZ\Columns\Types\TypeGender',
		'timestamp' => '\OZONE\OZ\Columns\Types\TypeTimestamp',
		'file'      => '\OZONE\OZ\Columns\Types\TypeFile',
		// 'image' => '\OZONE\OZ\Columns\Types\TypeImage'
	];
