<?php

namespace Merlion\Exceptions;

use Exception;
use Throwable;

class NoDefaultPanelSetException extends Exception
{
    final public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function make(): static
    {
        return new static('No default admin panel is set. You may do this with the `default()` method inside a Panel provider\'s `panel()` configuration.');
    }
}
