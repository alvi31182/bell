<?php

declare(strict_types=1);

namespace App\Controller\Author;

use App\Service\Authors\AuthorCreateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * @Route("/authors")
 */
class CreateAuthorController extends AbstractController
{
    private AuthorCreateService $createService;

    /**
     * @param AuthorCreateService $createService
     */
    public function __construct(AuthorCreateService $createService)
    {
        $this->createService = $createService;
    }

    /**
     * @return JsonResponse
     *
     * @Route("/create", methods={"GET"})
     */
    public function create(): JsonResponse
    {
        return new JsonResponse();
    }
}