<?php
	/**
	 * Copyright (c) 2017-present, Emile Silas Sare
	 *
	 * This file is part of OZone (O'Zone) package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace OZONE\OZ\FS;

	defined('OZ_SELF_SECURITY_CHECK') or die;

	class FilesManager
	{
		/**
		 * Current directory root.
		 *
		 * @var string
		 */
		private $root;

		/**
		 * FilesManager constructor.
		 *
		 * @param string $root the directory root path
		 */
		public function __construct($root = '.')
		{
			$this->root = PathUtils::resolve(OZ_PROJECT_DIR, $root);
		}

		/**
		 * Gets current root.
		 *
		 * @return string
		 */
		public function getRoot()
		{
			return $this->root;
		}

		/**
		 * Resolve file to current root.
		 *
		 * @param string $target the path to resolve
		 *
		 * @return string
		 */
		public function resolve($target)
		{
			return PathUtils::resolve($this->root, $target);
		}

		/**
		 * Change the current directory root path.
		 *
		 * @param string $path        the path to set as root
		 * @param bool   $auto_create to automatically create directory
		 *
		 * @return $this
		 */
		public function cd($path, $auto_create = false)
		{
			$abs_path = PathUtils::resolve($this->root, $path);

			if (file_exists($abs_path)) {
				if (!is_dir($abs_path)) {
					trigger_error(sprintf('Invalid directory: %s', $abs_path), E_USER_ERROR);
				}
			} elseif ($auto_create === true) {
				$this->mkdir($abs_path);
			} else {
				trigger_error(sprintf('Directory does not exists: %s', $abs_path),E_USER_ERROR);
			}

			$this->root = $abs_path;

			return $this;
		}

		/**
		 * Creates a symbolic link to a given target.
		 *
		 * @param string $target the target path
		 * @param string $name   the link name
		 *
		 * @return $this
		 */
		public function ln($target, $name)
		{
			$abs_target      = PathUtils::resolve($this->root, $target);
			$abs_destination = PathUtils::resolve($this->root, $name);

			if (!file_exists($abs_target)) {
				trigger_error(sprintf('Directory does not exists: %s', $abs_target), E_USER_ERROR);
			} elseif (file_exists($abs_destination)) {
				trigger_error(sprintf('Cannot overwrite: %s', $abs_destination), E_USER_ERROR);
			}

			symlink($abs_target, $abs_destination);

			return $this;
		}

		/**
		 * Copy file/directory.
		 *
		 * @param string      $from    the file/directory to copy
		 * @param string|null $to      the destination path
		 * @param array|null  $options the options
		 *
		 * @return $this
		 */
		public function cp($from, $to = null, array $options = [])
		{
			$to = empty($to) ? $this->root : (string)$to;

			$abs_from = PathUtils::resolve($this->root, (string)$from);
			$abs_to   = PathUtils::resolve($this->root, $to);

			if (file_exists($abs_from)) {
				if (is_dir($abs_from)) {
					if (file_exists($abs_to) AND !is_dir($abs_to)) {
						trigger_error(sprintf('Cannot overwrite non-directory "%s" with directory "%s".', $abs_to, $abs_from), E_USER_ERROR);
					}

					$this->mkdir($abs_to);
					self::recurseCopyDirAbsPath($abs_from, $abs_to, $options);
				} else {
					if (is_dir($abs_to)) {
						$abs_to = PathUtils::resolve($abs_to, basename($abs_from));
					}

					$this->mkdir(dirname($abs_to));
					copy($abs_from, $abs_to);
				}
			} else {
				trigger_error(sprintf('"%s" does not exists.', $abs_from), E_USER_ERROR);
			}

			return $this;
		}

		/**
		 * Write content to file.
		 *
		 * @param string $path    the file path
		 * @param string $content the content
		 * @param string $mode    php file write mode
		 *
		 * @return $this
		 */
		public function wf($path, $content = '', $mode = 'w')
		{
			$abs_path = PathUtils::resolve($this->root, $path);

			$f = fopen($abs_path, $mode);
			fwrite($f, $content);
			fclose($f);

			return $this;
		}

		/**
		 * Creates a directory at a given path with all parents directories
		 *
		 * @param string $path The directory path
		 * @param int    $mode The mode is 0777 by default, which means the widest possible access
		 *
		 * @return $this
		 */
		public function mkdir($path, $mode = 0777)
		{
			$abs_path = PathUtils::resolve($this->root, $path);

			if (!is_dir($abs_path)) {
				if (false === @mkdir($abs_path, $mode, true) AND !is_dir($abs_path)) {
					trigger_error(sprintf('Cannot create directory: "%s"', $abs_path),E_USER_ERROR);
				}
			}

			return $this;
		}

		/**
		 * Removes file/directory at a given path.
		 *
		 * @param string $path the file/directory path
		 *
		 * @return $this
		 */
		public function rm($path)
		{
			$abs_path = PathUtils::resolve($this->root, $path);

			if (is_file($abs_path)) {
				unlink($abs_path);
			} else {
				self::recurseRemoveDirAbsPath($abs_path);
			}

			return $this;
		}

		/**
		 * Removes directory recursively.
		 *
		 * @param string $path the directory path
		 *
		 * @return bool
		 */
		private static function recurseRemoveDirAbsPath($path)
		{
			$files = scandir($path);

			foreach ($files as $file) {
				if (!($file === '.' OR $file === '..')) {
					$src = $path . DS . $file;
					if (is_dir($src)) {
						self::recurseRemoveDirAbsPath($src);
					} else {
						unlink($src);
					}
				}
			}

			return rmdir($path);
		}

		/**
		 * Copy directory recursively.
		 *
		 * @param string $source
		 * @param string $destination
		 * @param array  $options
		 */
		private static function recurseCopyDirAbsPath($source, $destination, array $options)
		{
			$res = opendir($source);
			if (!file_exists($destination)) {
				mkdir($destination);
			}

			$exclude = isset($options["exclude"]) ? $options["exclude"] : null;
			$include = isset($options["include"]) ? $options["include"] : null;

			while (false !== ($file = readdir($res))) {
				if ($file != '.' AND $file != '..') {
					$from = $source . DS . $file;
					$to   = $destination . DS . $file;

					if (isset($exclude)) {
						if (is_callable($exclude)) {
							if (call_user_func_array($exclude, [$file, $from, $to])) {
								continue;
							}
						} elseif (is_string($exclude) AND preg_match($exclude, $from)) {
							continue;
						}
					}

					if (isset($include)) {
						if (is_callable($include)) {
							if (!call_user_func_array($include, [$file, $from, $to])) {
								continue;
							}
						} elseif (is_string($exclude) AND !preg_match($include, $from)) {
							continue;
						}
					}

					if (is_dir($from)) {
						self::recurseCopyDirAbsPath($from, $to, $options);
					} else {
						copy($from, $to);
					}
				}
			}

			closedir($res);
		}

		/**
		 * Checks if a given directory is empty
		 *
		 * @param string $dir the directory path
		 *
		 * @return bool|null
		 */
		public static function isEmptyDir($dir)
		{
			if (!is_readable($dir)) {
				return null;
			}

			$handle = opendir($dir);
			$yes    = true;

			while (false !== ($entry = readdir($handle))) {
				if ($entry !== '.' && $entry !== '..') {
					$yes = false;
					break;
				}
			}

			closedir($handle);

			return $yes;
		}

		/**
		 * Checks if the current root is equal to a given path.
		 *
		 * @param string $path the path to check
		 *
		 * @return bool
		 */
		public function isSelf($path)
		{
			$path = $this->resolve($path);

			return ($path === $this->root) ? true : false;
		}

		/**
		 * Checks if the current root is parent of a given path.
		 *
		 * @param string $path the path to check
		 *
		 * @return bool
		 */
		public function isParentOf($path)
		{
			$path = $this->resolve($path);

			if ($path === $this->root) {
				return false;
			}

			return (0 === strpos($path, $this->root)) ? true : false;
		}
	}