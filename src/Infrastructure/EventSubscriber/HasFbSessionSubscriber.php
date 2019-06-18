<?php


namespace App\Infrastructure\EventSubscriber;


use App\Infrastructure\Controllers\HasFbSessionController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HasFbSessionSubscriber implements EventSubscriberInterface
{

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof HasFbSessionController) {

            $request = $event->getRequest();
            $session = $request->getSession();
            if ($session->get('ownerFbDelegated') === null) {
                throw new AccessDeniedHttpException('This action needs a valid session!');
            }

        }

    }

    static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
