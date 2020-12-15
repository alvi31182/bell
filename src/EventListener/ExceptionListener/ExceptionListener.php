<?php

declare(strict_types=1);

namespace App\EventListener\ExceptionListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event){
        dd($event);
    }
}