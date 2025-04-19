<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct(string $defaultLocale = 'fr')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        if ($request->query->has('_locale')) {
            $locale = $request->query->get('_locale');
            $session->set('_locale', $locale);
        }

        if ($session->has('_locale')) {
            $request->setLocale($session->get('_locale'));
        } else {
            $request->setLocale($this->defaultLocale);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
