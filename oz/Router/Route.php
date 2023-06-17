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

namespace OZONE\Core\Router;

use InvalidArgumentException;
use OZONE\Core\App\Context;

/**
 * Class Route.
 */
final class Route
{
	public const DEFAULT_PARAM_PATTERN = '[^/]+';
	public const REG_DELIMITER         = '~';
	public const ROUTE_PARAM_REG       = '~^[a-z_][a-z0-9_]*$~';

	/**
	 * @var callable
	 */
	private $handler;

	private bool   $parsed = false;
	private string $parser_result;
	private array  $params = [];

	/**
	 * Route constructor.
	 *
	 * @param \OZONE\Core\Router\Router       $router
	 * @param array                           $methods
	 * @param callable                        $callable
	 * @param \OZONE\Core\Router\RouteOptions $options
	 */
	public function __construct(
		private readonly Router $router,
		private readonly array $methods,
		callable $callable,
		private readonly RouteOptions $options
	) {
		$this->handler = $callable;
	}

	/**
	 * Gets route name.
	 *
	 * Shortcut of {@see \OZONE\Core\Router\RouteOptions::getName()}
	 */
	public function getName(): string
	{
		return $this->options->getName();
	}

	/**
	 * Checks if this route is dynamic.
	 *
	 * @return bool
	 */
	public function isDynamic(): bool
	{
		$path = $this->options->getPath();

		return \str_contains($path, '{')
			   || \str_contains($path, ':')
			   || \str_contains($path, '[');
	}

	/**
	 * Builds the route path with given parameters values.
	 *
	 * @param \OZONE\Core\App\Context $context
	 * @param array                   $params
	 *
	 * @return string
	 */
	public function buildPath(Context $context, array $params = []): string
	{
		$path = $this->options->getPath();
		if (!$this->isDynamic()) {
			return $path;
		}

		$this->ensureParsed();

		return $this->pathBuilder($context, $path, $params);
	}

	/**
	 * Returns the route path as defined.
	 *
	 * @param bool $full
	 *
	 * @return string
	 */
	public function getPath(bool $full = true): string
	{
		return $this->options->getPath($full);
	}

	/**
	 * Returns the route handler callable.
	 *
	 * @return callable
	 */
	public function getHandler(): callable
	{
		return $this->handler;
	}

	/**
	 * Returns the route options.
	 *
	 * @return \OZONE\Core\Router\RouteOptions
	 */
	public function getOptions(): RouteOptions
	{
		return $this->options;
	}

	/**
	 * Returns this route allowed HTTP request methods.
	 *
	 * @return array
	 */
	public function getMethods(): array
	{
		return $this->methods;
	}

	/**
	 * Checks if this route accept a given HTTP request method.
	 *
	 * @param string $method
	 *
	 * @return bool
	 */
	public function accept(string $method): bool
	{
		return \in_array(\strtoupper($method), $this->methods, true);
	}

	/**
	 * Returns parser result.
	 *
	 * @return string
	 */
	public function getParserResult(): string
	{
		$this->ensureParsed();

		return $this->parser_result;
	}

	/**
	 * Returns parameters.
	 *
	 * @return array
	 */
	public function getParams(): array
	{
		$this->ensureParsed();

		return $this->params;
	}

	/**
	 * Checks if a given path matches this route.
	 *
	 * @param string     $path
	 * @param null|array $params
	 *
	 * @return bool
	 */
	public function is(string $path, ?array &$params = []): bool
	{
		$this->ensureParsed();

		if (!$this->isDynamic()) {
			return $path === $this->options->getPath();
		}

		$regexp  = self::REG_DELIMITER . '^' . $this->parser_result . '$' . self::REG_DELIMITER;
		$matches = [];
		$passed  = 1 === \preg_match($regexp, $path, $matches);

		if ($passed) {
			$params = $matches;
		}

		return $passed;
	}

	/**
	 * Checks if a parameter is valid.
	 *
	 * @param $str
	 *
	 * @return bool
	 */
	public static function isValidParameter($str): bool
	{
		return 1 === \preg_match(self::ROUTE_PARAM_REG, $str);
	}

	/**
	 * This will lazily parse the route path.
	 */
	private function ensureParsed(): void
	{
		if (!$this->parsed) {
			$path = $this->options->getPath();
			if ($this->isDynamic()) {
				$params              = [];
				$declared_params     = \array_merge($this->router->getGlobalParams(), $this->options->getParams());
				$this->parser_result = self::parse($path, $declared_params, $params);
				$this->params        = \array_keys($params);
			} else {
				$this->parser_result = $path;
			}

			$this->parsed = true;
		}
	}

	/**
	 * Builds dynamic path.
	 *
	 * @param \OZONE\Core\App\Context $context
	 * @param string                  $route
	 * @param array                   $params
	 * @param null|string             $original_route
	 *
	 * @return string
	 */
	private function pathBuilder(
		Context $context,
		string $route,
		array $params = [],
		?string $original_route = null
	): string {
		$len            = \strlen($route);
		$original_route = $original_route ?? $route;
		$path           = '';
		$cursor         = 0;

		while ($cursor < $len) {
			$c = $route[$cursor];

			if ('{' === $c || ':' === $c) {
				if ('{' === $c) {
					$name = self::searchUntilCloseTag('{', '}', $route, $cursor + 1, $cursor, false);
				} else {
					$name   = self::searchWhile($route, $cursor + 1, [self::class, 'isValidParameter']);
					$cursor += \strlen($name);
				}

				$required = ($route === $original_route ? 1 : 0);

				if (isset($params[$name])) {
					$path .= $params[$name];
				} else {
					$value = $this->router->getGlobalParamValue($context, $name);

					if (null !== $value) {
						$path .= $value;
					} elseif ($required) {
						throw new InvalidArgumentException(\sprintf(
							'Missing required parameter value: %s',
							$name
						));
					} else {
						// we are in optional part and
						// there is missing param value
						// so we ignore the optional part
						return '';
					}
				}
			} elseif ('[' === $c) {
				$optional = self::searchUntilCloseTag('[', ']', $route, $cursor + 1, $cursor, true);

				if ('' === $optional) {
					throw new InvalidArgumentException(\sprintf(
						'Optional part should not be empty: %s',
						$original_route
					));
				}

				$path .= $this->pathBuilder($context, $optional, $params, $original_route);
			} else {
				$path .= $c;
			}

			++$cursor;
		}

		return $path;
	}

	/**
	 * Dynamic route parser.
	 *
	 * @param string      $route_path
	 * @param array       $declared_params
	 * @param array       &$params_found
	 * @param null|string $original_route
	 *
	 * @return string
	 */
	private static function parse(
		string $route_path,
		array $declared_params = [],
		array &$params_found = [],
		?string $original_route = null
	): string {
		$len            = \strlen($route_path);
		$original_route = $original_route ?? $route_path;
		$pattern        = '';
		$cursor         = 0;

		while ($cursor < $len) {
			$c = $route_path[$cursor];

			if ('{' === $c || ':' === $c) {
				if ('{' === $c) {
					$name = self::searchUntilCloseTag('{', '}', $route_path, $cursor + 1, $cursor, false);
				} else {
					$name   = self::searchWhile($route_path, $cursor + 1, [self::class, 'isValidParameter']);
					$cursor += \strlen($name);
				}

				if ('' === $name) {
					throw new InvalidArgumentException(\sprintf(
						'Route parameter name should not be empty: %s',
						$original_route
					));
				}

				if (!\preg_match(self::ROUTE_PARAM_REG, $name)) {
					throw new InvalidArgumentException(\sprintf(
						'Route parameter name contains invalid characters: %s -> %s',
						$name,
						$original_route
					));
				}

				if (\array_key_exists($name, $params_found)) {
					throw new InvalidArgumentException(\sprintf(
						'Route parameter name duplicated: %s -> %s',
						$name,
						$original_route
					));
				}

				$param_pattern = $declared_params[$name] ?? self::DEFAULT_PARAM_PATTERN;

				// use (?P<name> insteadof (?<name> for backward compatibility
				$pattern .= "(?P<{$name}>{$param_pattern})";
				$required            = ($route_path === $original_route ? 1 : 0);
				$params_found[$name] = $required;
			} elseif ('[' === $c) {
				$optional = self::searchUntilCloseTag('[', ']', $route_path, $cursor + 1, $cursor, true);

				if ('' === $optional) {
					throw new InvalidArgumentException(\sprintf(
						'Optional part should not be empty: %s',
						$original_route
					));
				}

				$optional_reg = self::parse($optional, $declared_params, $params_found, $original_route);
				$pattern .= '(?:' . $optional_reg . ')?';
			} else {
				$pattern .= \preg_quote($c, self::REG_DELIMITER);
			}

			++$cursor;
		}

		return $pattern;
	}

	/**
	 * Search for close tag.
	 *
	 * @param string $open      open tag
	 * @param string $close     close tag
	 * @param string $string    string to search in
	 * @param int    $from      start index
	 * @param int    $found_at  found index
	 * @param bool   $go_deeply go deeply
	 *
	 * @return string
	 */
	private static function searchUntilCloseTag(
		string $open,
		string $close,
		string $string,
		int $from,
		int &$found_at,
		bool $go_deeply
	): string {
		$found       = false;
		$accumulator = '';
		$cursor      = $from;
		$len         = \strlen($string);
		$stack       = 0;

		while ($cursor < $len) {
			$c = $string[$cursor];

			if ($c === $open) {
				if ($go_deeply) {
					++$stack;
				} else {
					throw new InvalidArgumentException(\sprintf(
						'The open tag "%s" at index %s was not closed before opening new tag at index %s',
						$open,
						$from - 1,
						$cursor
					));
				}
			}

			if ($c === $close) {
				if ($stack) {
					--$stack;
				} else {
					$found    = true;
					$found_at = $cursor;

					break;
				}
			}

			$accumulator .= $c;
			++$cursor;
		}

		if (false === $found) {
			throw new InvalidArgumentException(\sprintf(
				'Unexpected end of string missing close tag "%s" at the end of "%s"',
				$close,
				$string
			));
		}

		return $accumulator;
	}

	/**
	 * Search while a given callable return true.
	 *
	 * @param string   $string    the string to search in
	 * @param int      $from      the index to start searching from
	 * @param callable $predicate the predicate function
	 *
	 * @return string
	 */
	private static function searchWhile(string $string, int $from, callable $predicate): string
	{
		$accumulator = '';
		$cursor      = $from;
		$len         = \strlen($string);

		while ($cursor < $len) {
			$char = $string[$cursor];

			if (!$predicate($accumulator . $char)) {
				break;
			}

			$accumulator .= $char;
			++$cursor;
		}

		return $accumulator;
	}
}
