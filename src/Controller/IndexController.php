<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\Book\RequestCreateBook;
use App\EventListener\LocaleSubscriber;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * @Route("/")
 */
final class IndexController
{
    private LocaleSubscriber $subs;

    public function __construct(LocaleSubscriber $subs){
        $this->subs = $subs;
    }

    public function index(Request $request):JsonResponse
    {
        return new JsonResponse(
            'hello',200,[],true
        );
    }
}