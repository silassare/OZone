<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of the OZone package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace OZONE\OZ\FS\Services;

	use OZONE\OZ\Core\Assert;
	use OZONE\OZ\Core\BaseService;
	use OZONE\OZ\Core\SettingsManager;
	use OZONE\OZ\Exceptions\InternalErrorException;
	use OZONE\OZ\Exceptions\NotFoundException;
	use OZONE\OZ\FS\ImagesUtils;

	defined('OZ_SELF_SECURITY_CHECK') or die;

	class FilesServer extends BaseService
	{
		/**
		 * FilesServer constructor.
		 */
		public function __construct()
		{
			parent::__construct();
		}

		/**
		 * {@inheritdoc}
		 *
		 * @param array $request
		 *
		 * @throws \OZONE\OZ\Exceptions\InternalErrorException
		 * @throws \OZONE\OZ\Exceptions\InvalidFormException
		 * @throws \OZONE\OZ\Exceptions\NotFoundException
		 */
		public function execute(array $request = [])
		{
			Assert::assertForm($request, [
				'file_src',
				'file_name',
				'file_mime',
				'file_quality'
			], new NotFoundException());

			set_time_limit(0);

			$src = $request['file_src'];

			if (empty($src) || !file_exists($src) || !is_file($src) || !is_readable($src)) {
				throw new NotFoundException();
			}

			$file_name    = $request['file_name'];
			$file_mime    = $request['file_mime'];
			$file_quality = intval($request['file_quality']);
			$size         = filesize($src);

			// close the current session
			if (session_id()) session_write_close();

			// clean output buffer
			if (ob_get_contents()) ob_clean();

			header('Pragma: public');
			header('Expires: 99936000');
			header('Cache-Control: public, max-age=99936000');
			header('Content-Transfer-Encoding: binary');
			header("Content-Length: $size");
			header("Content-type: $file_mime");
			header("Content-Disposition: attachment; filename='$file_name';");

			if ($file_quality > 0) {
				// thumbnails
				// 0: 'original file'
				// 1: 'low quality',
				// 2: 'normal quality',
				// 3: 'high quality'
				$jpeg_quality_array = [60, 80, 100];
				$jpeg_quality       = $jpeg_quality_array[$file_quality - 1];
				$img_utils_obj      = new ImagesUtils($src);

				if ($img_utils_obj->load()) {
					$max_size = SettingsManager::get('oz.users', 'OZ_THUMB_MAX_SIZE');
					$advice   = $img_utils_obj->adviceBestSize($max_size, $max_size);
					$img_utils_obj->resizeImage($advice['w'], $advice['h'], $advice['crop'])
								  ->outputJpeg($jpeg_quality);
				} else {
					$this->sendOriginal($src);
				}
			} else {
				$this->sendOriginal($src);
			}
		}

		/**
		 * send a file at a given path to the client
		 *
		 * @param string $path the file path
		 */
		private function sendOriginal($path)
		{
			flush();
			readfile($path);
			exit;
		}

		/**
		 * starts a file download server
		 *
		 * @param array $options      the server options
		 * @param bool  $allow_resume should we support download resuming
		 * @param bool  $is_stream    is it a stream
		 *
		 * @throws \OZONE\OZ\Exceptions\InternalErrorException
		 * @throws \OZONE\OZ\Exceptions\UnauthorizedActionException
		 */
		public static function startDownloadServer(array $options, $allow_resume = false, $is_stream = false)
		{
			// - turn off compression on the server
			@apache_setenv('no-gzip', 1);
			@ini_set('zlib.output_compression', 'Off');

			$mime_default = "application/octet-stream";
			$file_src     = $options['file_src'];
			$file_name    = isset($options['file_name']) ? $options['file_name'] : basename($file_src);
			$expires_date = isset($options['file_expires_date']) ? $options['file_expires_date'] : -1;
			$mime         = isset($options['file_mime']) ? $options['file_mime'] : $mime_default;
			$range        = '';

			// make sure the file exists
			Assert::assertAuthorizeAction(is_file($file_src), new NotFoundException());

			$file_size = filesize($file_src);
			$file      = @fopen($file_src, 'rb');

			// make sure file open success
			if (!$file) throw new InternalErrorException('OZ_FILE_OPEN_ERROR', [$file_src]);

			// set the headers, prevent caching
			header('Pragma: public');
			header('Expires: ' . $expires_date);
			header('Cache-Control: public, max-age=' . $expires_date . ', must-revalidate, post-check=0, pre-check=0');

			// set appropriate headers for attachment or streamed file
			if (!$is_stream) {
				header("Content-Disposition: attachment; filename='$file_name';");
			} else {
				header('Content-Disposition: inline;');
				header('Content-Transfer-Encoding: binary');
			}

			// set the mime type
			header("Content-Type: " . $mime);

			// check if http_range is sent by browser (or download manager)
			if ($allow_resume AND isset($_SERVER['HTTP_RANGE'])) {
				list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
				if ($size_unit === 'bytes') {
					// multiple ranges could be specified at the same time, but for simplicity only serve the first range
					// http://tools.ietf.org/id/draft-ietf-http-range-retrieval-00.txt
					@list($range) = explode(',', $range_orig, 2);
				} else {
					header('HTTP/1.1 416 Requested Range Not Satisfiable');
					exit;
				}
			}

			// figure out download piece from range (if set)
			@list($seek_start, $seek_end) = explode('-', $range, 2);

			// set start and end based on range (if set), else set defaults
			// also check for invalid ranges.
			$seek_end   = (empty($seek_end)) ? ($file_size - 1) : min(abs(intval($seek_end)), ($file_size - 1));
			$seek_start = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)), 0);

			// Only send partial content header if downloading a piece of the file (IE workaround)
			if ($seek_start > 0 || $seek_end < ($file_size - 1)) {
				$chunk_size = ($seek_end - $seek_start + 1);

				header('HTTP/1.1 206 Partial Content');
				header('Content-Range: bytes ' . $seek_start . '-' . $seek_end . '/' . $file_size);
				header("Content-Length: $chunk_size");
			} else {
				header("Content-Length: $file_size");
			}

			header('Accept-Ranges: bytes');

			set_time_limit(0);
			fseek($file, $seek_start);

			while (!feof($file)) {
				print(@fread($file, 1024 * 8));
				ob_flush();
				flush();
				if (connection_status() != 0) {
					@fclose($file);
					exit;
				}
			}

			// file download was a success
			@fclose($file);
			exit;
		}
	}