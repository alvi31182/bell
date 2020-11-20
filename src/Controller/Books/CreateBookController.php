<?php

declare(strict_types=1);

namespace App\Controller\Books;

use App\Data\Book\RequestCreateBook;
use App\Service\Books\BookCreateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * @Route("/book")
 */
final class CreateBookController extends AbstractController
{
    private BookCreateService $bookCreateService;

    public function __construct(BookCreateService $bookCreateService)
    {
        $this->bookCreateService = $bookCreateService;
    }

    /**
     * @Route("/create", methods={"POST"})
     * @param RequestCreateBook $requestCreateBook
     * @return JsonResponse
     */
    public function bookCreate(RequestCreateBook $requestCreateBook): JsonResponse
    {
        $this->bookCreateService->create($requestCreateBook);
        return new JsonResponse();
    }
}