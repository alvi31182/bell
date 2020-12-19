<?php

declare(strict_types=1);

namespace App\Controller\Books;

use App\Data\Book\RequestCreateBook;
use App\EventListener\LocaleSubscriber;
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
    private LocaleSubscriber $localeSubscriber;

    public function __construct(BookCreateService $bookCreateService, LocaleSubscriber $localeSubscriber)
    {
        $this->bookCreateService = $bookCreateService;
        $this->localeSubscriber = $localeSubscriber;
    }

    /**
     * @Route("/create", methods={"POST"})
     * @param RequestCreateBook $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function bookCreate(RequestCreateBook $request): JsonResponse
    {
        return new JsonResponse(
            [
                "book_created" => $this->bookCreateService->create($request)
            ]
        );
    }
}