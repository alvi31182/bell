<?php


namespace App\Entity\Security;


use LitGroup\Enumerable\Enumerable;

class UserStatus extends Enumerable
{
    public static function moderate(): self
    {
        return self::createEnum('moderate');
    }

    public static function enable(): self
    {
        return self::createEnum('enable');
    }

    public static function disable(): self
    {
        return self::createEnum('disable');
    }
}