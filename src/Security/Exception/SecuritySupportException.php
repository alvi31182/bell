<?php

declare(strict_types=1);

namespace App\Security\Exception;

use Throwable;

abstract class SecuritySupportException extends \Exception
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        parent::__construct(!empty($message) ? $message : $this->getMessageFromClassName(), $code, $previous);
    }

    public function getMessageFromClassName(): string
    {
        $string = (new \ReflectionClass($this))->getShortName();

        $string[0] = strtolower($string[0]);

        $function = function (array $s) {
            return ' ' . strtolower($s[1]);
        };

        return ucfirst(preg_replace_callback('/([A-Z])/', $function, $string));
    }
}