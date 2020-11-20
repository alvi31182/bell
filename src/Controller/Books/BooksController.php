<?php

declare(strict_types=1);

namespace App\Controller\Books;

use App\Data\Book\RequestBookData;
use App\Service\Books\BooksGetListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/book")
 */
class BooksController extends AbstractController
{
    private BooksGetListService $bookListService;
    private SerializerInterface $serializer;

    public function __construct(BooksGetListService $bookListService, SerializerInterface $serializer)
    {
        $this->bookListService = $bookListService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/search", methods={"GET"})
     * @param RequestBookData $request
     * @return JsonResponse
     */
    public function findBook(RequestBookData $request): JsonResponse
    {

        $searchRequest = $this->bookListService->findBook($request->getTitle());

        $data = [
            "Книга" => $searchRequest
        ];

        return new JsonResponse(
            $this->serializer->serialize($data,'json',[]),Response::HTTP_OK,[],true
        );
    }
}