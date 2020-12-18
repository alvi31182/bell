<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final class LocaleSubscriber implements EventSubscriberInterface
{
    private array $supportLocale;
    private string $defaultLocale;
    private string $currentLocale;

    public function __construct(string $defaultLocale, array $supportLocale, string $currentLocale = '')
    {
        $this->supportLocale = $supportLocale;
        $this->defaultLocale = $defaultLocale;
        $this->currentLocale = $currentLocale;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        foreach ($event->getRequest()->getLanguages() as $locale) {
            if (in_array($locale, $this->supportLocale)) {
                $event->getRequest()->setLocale($locale);
                $this->currentLocale = $locale;
                return;
            }
        }
        $event->getRequest()->setLocale($this->defaultLocale);
        $this->currentLocale = $this->defaultLocale;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('Content-Language', $this->currentLocale);
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => ['onKernelRequest', 9],
            ResponseEvent::class => ['onKernelResponse', 0]
        ];
    }
}