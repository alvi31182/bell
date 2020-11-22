<?php

declare(strict_types=1);

namespace App\EventSubscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

final class LocaleSubscriber implements EventSubscriberInterface
{

    private TranslatorInterface $translator;

    private array $supportedLocales;

    private string $defaultLocale;

    private string $currentLocale;

    public function __construct(TranslatorInterface $translator, array $supportedLocales, string $defaultLocale){
        $this->translator = $translator;
        $this->supportedLocales = $supportedLocales;
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event): void
    {

        foreach ($event->getRequest()->getLanguages() as $locale) {
            if (in_array($locale, $this->supportedLocales)) {
                $this->translator->setLocale($locale);
                $this->currentLocale = $locale;
                return;
            }
        }

        $this->translator->setLocale($this->defaultLocale);
        $this->currentLocale = $this->defaultLocale;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set('Content-Language', $this->currentLocale);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST  => ['onKernelRequest', 9],
            KernelEvents::RESPONSE  => ['onKernelResponse', 0],
        ];
    }
}