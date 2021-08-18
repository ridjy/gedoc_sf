<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest($event)
    {
        $request = $event->getRequest();
        $uri = $_SERVER['REQUEST_URI'];
        if ($request->getSession()->get('user_connecte') == NULL && $uri!='/')
        {
            $event->setResponse(new RedirectResponse('/'));    
        }//endif
        //redirect si pas de user connecte
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}

