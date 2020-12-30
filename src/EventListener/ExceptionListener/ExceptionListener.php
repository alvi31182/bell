<?php

declare(strict_types=1);

namespace App\EventListener\ExceptionListener;

use App\Service\Security\Exception\NotFoundUserException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class ExceptionListener
{

    public function onKernelException(ExceptionEvent $event):Response
    {
        $exception = $event->getThrowable();

        $message = sprintf('%s',$exception->getMessage());

        $response = new Response();

        $response->setContent($message);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /*if ($exception instanceof NotFoundUserException) {

        }*/

        return new JsonResponse(['error' => $event->getResponse()], Response::HTTP_FOUND,[],false);
    }
}