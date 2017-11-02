<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of the OZone package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace OZONE\OZ\Exceptions;

	defined('OZ_SELF_SECURITY_CHECK') or die;

	/**
	 * Class BadRequestException
	 *
	 * @package OZONE\OZ\Exceptions
	 */
	class BadRequestException extends BaseException
	{

		/**
		 * BadRequestException constructor.
		 *
		 * @param string     $message the exception message
		 * @param array|null $data    additional exception data
		 */
		public function __construct($message = 'OZ_ERROR_BAD_REQUEST', array $data = null)
		{
			parent::__construct($message, BaseException::BAD_REQUEST, $data);
		}

		/**
		 * {@inheritdoc}
		 */
		public function procedure()
		{
			$this->informClient();
		}
	}