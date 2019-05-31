<?php

declare(strict_types=1);

namespace Libero\MediaType;

use OutOfBoundsException;
use function implode;
use function in_array;
use function mb_substr;
use function rtrim;
use function trim;

/**
 * @internal
 */
function string_is(string $string, string ...$options) : bool
{
    return in_array($string, $options, true);
}

/**
 * @internal
 */
function string_will_be(string ...$options) : callable
{
    return static function (string $string) use ($options) : bool {
        return string_is($string, ...$options);
    };
}

/**
 * @internal
 */
function get_character(string $string, int $position) : string
{
    $character = mb_substr($string, $position, 1);

    if ('' === $character) {
        throw new OutOfBoundsException('No character at position');
    }

    return $character;
}

/**
 * @internal
 */
function multi_trim(string $string, string ...$characters) : string
{
    return trim($string, implode('', $characters));
}

/**
 * @internal
 */
function multi_rtrim(string $string, string ...$characters) : string
{
    return rtrim($string, implode('', $characters));
}
