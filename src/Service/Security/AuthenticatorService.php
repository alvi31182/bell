<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Repository\Security\User\UserReadStorage;
use DateInterval;

final class AuthenticatorService
{
    private UserReadStorage $userReadStorage;
    private ApiTokenService $apiTokenService;
    private DateInterval $tokenTtl;

    /**
     * @param UserReadStorage $userReadStorage
     * @param ApiTokenService $apiTokenService
     * @param DateInterval $tokenTtl
     */
    public function __construct(UserReadStorage $userReadStorage, ApiTokenService $apiTokenService, DateInterval $tokenTtl)
    {
        $this->userReadStorage = $userReadStorage;
        $this->apiTokenService = $apiTokenService;
        $this->tokenTtl = $tokenTtl;
    }

    public function authenticateUser(string $email, string $password): string
    {

        $user = $this->userReadStorage->findByEmail($email);

        if(!$user){
            dd('error login');
        }

        return $this->apiTokenService->createToken($user, $this->tokenTtl);
    }

}