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
	 * Class InternalErrorException
	 *
	 * @package OZONE\OZ\Exceptions
	 */
	class InternalErrorException extends BaseException
	{

		/**
		 * InternalErrorException constructor.
		 *
		 * @param string          $message  the exception message
		 * @param array|null      $data     additional exception data
		 * @param \Exception|null $previous previous exception if nested exception
		 */
		public function __construct($message = 'OZ_ERROR_INTERNAL', array $data = null, \Exception $previous = null)
		{
			parent::__construct($message, BaseException::INTERNAL_ERROR, $data, $previous);
		}

		/**
		 * {@inheritdoc}
		 */
		public function procedure()
		{
			$this->informClient();
		}
	}