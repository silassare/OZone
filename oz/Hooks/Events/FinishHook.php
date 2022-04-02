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

namespace OZONE\OZ\Hooks\Events;

use OZONE\OZ\Http\Request;
use OZONE\OZ\Http\Response;
use PHPUtils\Events\Event;

/**
 * Class FinishHook.
 *
 * This event is triggered when the response
 * is already sent to the client.
 *
 * !This event is not triggered for sub-request.
 */
final class FinishHook extends Event
{
	/**
	 * FinishHook constructor.
	 *
	 * @param \OZONE\OZ\Http\Request  $request
	 * @param \OZONE\OZ\Http\Response $response
	 */
	public function __construct(protected Request $request, protected Response $response)
	{
	}

	/**
	 * FinishHook destructor.
	 */
	public function __destruct()
	{
		unset($this->response, $this->request);
	}

	/**
	 * Gets the handled request.
	 *
	 * @return \OZONE\OZ\Http\Response
	 */
	public function getResponse(): Response
	{
		return $this->response;
	}

	/**
	 * Gets the request response.
	 *
	 * @return \OZONE\OZ\Http\Request
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}
}
