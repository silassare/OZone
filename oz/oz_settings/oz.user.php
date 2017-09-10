<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of the OZone package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	return [
		// class used to instantiate user object, must extends OZoneUserBase
		'OZ_USER_CLASS'           => 'OZONE\OZ\User\OZoneUser',
		// id par defaut s'il n'y en a pas
		'OZ_DEFAULT_PICID'        => '0_0',
		// taille maximale de crop d'une image de profile: en pixels
		'OZ_PPIC_MIN_SIZE'        => 150,
		// taille maximale d'un thumbnail: en pixels
		'OZ_THUMB_MAX_SIZE'       => 640,
		// liste du genre/sexe des utilisateurs autorisés
		'OZ_USER_ALLOWED_GENDERS' => ['Male', 'Female', 'None', 'Other'],
		// ozone uid are: unsigned bigint >= 1 max digits is 20
		'OZ_USER_UID_REG'         => '#^[1-9][0-9]{0,19}$#'
	];