<?php
namespace Application\Listener;

use Zend\EventManager\Event;

class RbacListener
{
    public static function accept(Event $event)
    {
        $event->stopPropagation();

        $accepted = true;

        $serviceLocator = $event->getTarget()->getServiceLocator()->getServiceLocator();
        $rbac           = $serviceLocator->get('ZfcRbac\Service\AuthorizationService');

        $params = $event->getParams();
        $page = $params['page'];

        $permission = $page->getPermission();

        if ($permission) {
            $accepted = $rbac->isGranted($permission);
        }

        return $accepted;
    }
}
