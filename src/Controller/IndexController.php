<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * @Route("/")
 */
final class IndexController
{
    public function index():JsonResponse
    {
        return new JsonResponse(
            'hello',200,[],true
        );
    }
}