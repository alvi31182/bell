<?php

declare(strict_types=1);

namespace App\Entity\Security;

use LitGroup\Enumerable\Enumerable;

final class UserStatus extends Enumerable
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