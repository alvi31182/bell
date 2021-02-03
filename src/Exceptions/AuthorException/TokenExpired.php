<?php

declare(strict_types=1);

namespace App\Exceptions\AuthorException;

use App\Security\Exception\SecuritySupportException;

class TokenExpired extends SecuritySupportException
{
}