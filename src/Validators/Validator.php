<?php

namespace App\Validators;

abstract class Validator
// This class contain the basic utils for validation
{
    /**
     * Check if a string is not empty.
     *
     * @param string $value
     * @return bool
     */
    public static function required(string $value): bool
    {
        return trim($value) !== '';
    }

    /**
     * Check if a string's length does not exceed the maximum length.
     *
     * @param string $value
     * @param int $maxLength
     * @return bool
     */
    public static function maxLength(string $value, int $maxLength): bool
    {
        return strlen($value) <= $maxLength;
    }

    /**
     * Check if a string's length is at least the minimum length.
     *
     * @param string $value
     * @param int $minLength
     * @return bool
     */
    public static function minLength(string $value, int $minLength): bool
    {
        return strlen($value) >= $minLength;
    }

    /**
     * Check if a value is a valid email address.
     *
     * @param string $value
     * @return bool
     */
    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Check if a value is a valid URL.
     *
     * @param string $value
     * @return bool
     */
    public static function url(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Check if a value is numeric.
     *
     * @param mixed $value
     * @return bool
     */
    public static function numeric($value): bool
    {
        return is_numeric($value);
    }

    /**
     * Check if a value is an integer.
     *
     * @param mixed $value
     * @return bool
     */
    public static function integer($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Validate that a value is greater than a specified threshold.
     *
     * @param float $value
     * @param float $threshold
     * @return bool
     */
    public static function greaterThan(float $value, float $threshold): bool
    {
        return $value > $threshold;
    }

    /**
     * Check if a value matches a regular expression pattern.
     *
     * @param string $value
     * @param string $pattern
     * @return bool
     */
    public static function regex(string $value, string $pattern): bool
    {
        return preg_match($pattern, $value) === 1;
    }

    /**
     * Check if a value is in a given array.
     *
     * @param mixed $value
     * @param array $list
     * @return bool
     */
    public static function inArray($value, array $list): bool
    {
        return in_array($value, $list, true);
    }

    /**
     * Check if a string is an exact length.
     *
     * @param string $value
     * @param int $length
     * @return bool
     */
    public static function exactLength(string $value, int $length): bool
    {
        return strlen($value) === $length;
    }

    /**
     * Check if a value is within a numeric range.
     *
     * @param float|int $value
     * @param float|int $min
     * @param float|int $max
     * @return bool
     */
    public static function between($value, $min, $max): bool
    {
        return $value >= $min && $value <= $max;
    }
}
