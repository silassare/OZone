<?php
	/**
	 * Auto generated file, please don't edit.
	 *
	 * With: Gobl v1.0.0
	 * Time: 1508868493
	 */

	namespace OZONE\OZ\Db;

	use OZONE\OZ\Db\Base\OZClient as BaseOZClient;

	class OZClient extends BaseOZClient
	{
		/**
		 * Checks if whether the client support multi user or not
		 *
		 * @return bool
		 */
		public function isMultiUserSupported()
		{
			return empty($this->getUserId());
		}

	}