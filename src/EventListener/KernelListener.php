<?php
// On veut rediriger notre page de http://127.0.0.1:8000 vers http://127.0.0.1:8000/fr/
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class KernelListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        // Retourne quelle méthode appeller en fonction de l'événement
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();
        $route = $request->get('_route');
        $locale = $request->get('_locale');

        // var_dump($route); // ex string(4) "home"
        // var_dump($locale); // ex: string(2) "fr"
        if (null == $route && null == $locale) {
            // La redirection se fait vers home (/{_locale}) => http://127.0.0.1:8000/fr/
            // $event->setResponse(new RedirectResponse($this->router->generate('wildUnicorn', ['_locale' => 'fr'])));
        }
    }
}
