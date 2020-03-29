<?php

/**
 * Copyright (c) 2017-present, Emile Silas Sare
 *
 * This file is part of OZone (O'Zone) package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OZONE\OZ\Exceptions;

use Throwable;

\defined('OZ_SELF_SECURITY_CHECK') || die;

/**
 * Class MethodNotAllowedException
 */
class MethodNotAllowedException extends BaseException
{
	/**
	 * MethodNotAllowedException constructor.
	 *
	 * @param null|string     $message  the exception message
	 * @param null|array      $data     additional exception data
	 * @param null|\Throwable $previous previous throwable used for the exception chaining
	 */
	public function __construct($message = null, array $data = null, Throwable $previous = null)
	{
		parent::__construct((empty($message) ? 'OZ_ERROR_METHOD_NOT_ALLOWED' : $message), BaseException::METHOD_NOT_ALLOWED, $data, $previous);
	}
}
