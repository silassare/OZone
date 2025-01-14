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

namespace OZONE\Core\Exceptions\Traits;

use OZONE\Core\Http\Response;

/**
 * Trait.
 */
trait ExceptionWithCustomResponseTrait
{
	protected ?Response $custom_response = null;

	/**
	 * Gets custom response.
	 *
	 * @return null|Response
	 */
	public function getCustomResponse(): ?Response
	{
		return $this->custom_response;
	}

	/**
	 * Sets custom response.
	 *
	 * @param Response $response
	 *
	 * @return static
	 */
	public function setCustomResponse(Response $response): static
	{
		$this->custom_response = $response;

		return $this;
	}
}
