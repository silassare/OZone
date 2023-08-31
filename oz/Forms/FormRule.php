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

namespace OZONE\Core\Forms;

use OZONE\Core\Lang\I18nMessage;
use PHPUtils\Interfaces\ArrayCapableInterface;
use PHPUtils\Traits\ArrayCapableTrait;

/**
 * Class FormRule.
 */
class FormRule implements ArrayCapableInterface
{
	use ArrayCapableTrait;

	/**
	 * @var array<int, array{field: string, rule: string, value?: mixed, target?: string, message:
	 *      null|\OZONE\Core\Lang\I18nMessage|string}>
	 */
	private array $rules                     = [];
	private null|string|I18nMessage $message = null;

	/**
	 * Add a rule to check if a field value is equal to a value.
	 *
	 * @param \OZONE\Core\Forms\Field|string                     $field
	 * @param null|bool|float|int|\OZONE\Core\Forms\Field|string $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string           $message
	 *
	 * @return $this
	 */
	public function eq(
		string|Field $field,
		Field|null|int|string|float|bool $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'eq', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is not equal to a value.
	 *
	 * @param \OZONE\Core\Forms\Field|string                     $field
	 * @param null|bool|float|int|\OZONE\Core\Forms\Field|string $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string           $message
	 *
	 * @return $this
	 */
	public function neq(
		string|Field $field,
		Field|null|int|string|float|bool $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'neq', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is greater than a value.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param float|int|\OZONE\Core\Forms\Field|string $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function gt(
		string|Field $field,
		Field|int|string|float $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'gt', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is greater than or equal to a value.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param float|int|\OZONE\Core\Forms\Field|string $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function gte(
		string|Field $field,
		Field|int|string|float $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'gte', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is less than a value.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param float|int|\OZONE\Core\Forms\Field|string $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function lt(
		string|Field $field,
		Field|int|string|float $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'lt', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is less than or equal to a value.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param float|int|\OZONE\Core\Forms\Field|string $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function lte(
		string|Field $field,
		Field|int|string|float $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'lte', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is in a list of values.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param array|\OZONE\Core\Forms\Field            $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function in(
		string|Field $field,
		Field|array $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'in', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is not in a list of values.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param array|\OZONE\Core\Forms\Field            $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function notIn(
		string|Field $field,
		Field|array $value,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'not_in', $value, $message);
	}

	/**
	 * Add a rule to check if a field value is null.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function isNull(
		string|Field $field,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'is_null', null, $message);
	}

	/**
	 * Add a rule to check if a field value is not null.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	public function isNotNull(
		string|Field $field,
		null|string|I18nMessage $message = null
	): self {
		return $this->add($field, 'is_not_null', null, $message);
	}

	/**
	 * Evaluates the rule conditions.
	 *
	 * Note: the value used in the rule is the unsafe value as provided in the request.
	 * We are not using the clean value because:
	 *  - We can't guarantee the order in which fields are validated.
	 *  - This should be portable to client side validation.
	 *
	 * @param \OZONE\Core\Forms\FormValidationContext $fvc
	 *
	 * @return bool
	 */
	public function check(FormValidationContext $fvc): bool
	{
		$unsafe_fd = $fvc->getUnsafeFormData();
		foreach ($this->rules as $entry) {
			$a = $unsafe_fd->get($entry['field']);
			$b = null;

			if (isset($entry['target'])) {
				$b = $unsafe_fd->get($entry['target']);
			} elseif (isset($entry['value'])) {
				$b = $entry['value'];
			}

			$this->message = $entry['message'];

			$ok = match ($entry['rule']) {
				'eq'          => ($a === $b),
				'neq'         => ($a !== $b),
				'gt'          => ($a > $b),
				'gte'         => ($a >= $b),
				'lt'          => ($a < $b),
				'lte'         => ($a <= $b),
				'in'          => \is_array($b) && \in_array($a, $b, true),
				'not_in'      => !\is_array($b) || !\in_array($a, $b, true),
				'is_null'     => null === $a,
				'is_not_null' => null !== $a,
			};

			if (!$ok) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Gets the error message.
	 *
	 * @return null|\OZONE\Core\Lang\I18nMessage|string
	 */
	public function getErrorMessage(): string|I18nMessage|null
	{
		return $this->message;
	}

	/**
	 * {@inheritDoc}
	 */
	public function toArray(): array
	{
		return $this->rules;
	}

	/**
	 * Adds a rule.
	 *
	 * @param \OZONE\Core\Forms\Field|string           $field
	 * @param string                                   $rule
	 * @param null|mixed                               $value
	 * @param null|\OZONE\Core\Lang\I18nMessage|string $message
	 *
	 * @return $this
	 */
	private function add(
		string|Field $field,
		string $rule,
		mixed $value = null,
		null|string|I18nMessage $message = null
	): self {
		$field_name = $field instanceof Field ? $field->getName() : $field;

		if ($value instanceof Field) {
			$this->rules[] = [
				'field'   => $field_name,
				'rule'    => $rule,
				'target'  => $value->getName(),
				'message' => $message,
			];
		} else {
			$this->rules[] = [
				'field'   => $field_name,
				'rule'    => $rule,
				'value'   => $value,
				'message' => $message,
			];
		}

		return $this;
	}
}
