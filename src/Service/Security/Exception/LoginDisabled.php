<?php

declare(strict_types=1);

namespace App\Service\Security\Exception;

use App\Security\Exception\SecuritySupportException;
use App\Security\Interfaces\SecurityError;

class LoginDisabled extends SecuritySupportException implements SecurityError
{

}