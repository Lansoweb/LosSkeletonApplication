<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;
use Zend\I18n\Translator\Translator;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sm = $e->getApplication()->getServiceManager();

        \Locale::setDefault('pt_BR');

        $translator = new Translator();
        $translator->addTranslationFile('phpArray', __DIR__ . '/../../../../vendor/zendframework/zendframework/resources/languages/pt_BR/Zend_Validate.php', 'default', 'pt_BR');
        $translator->addTranslationFile('phpArray', __DIR__ . '/../../../../vendor/zendframework/zendframework/resources/languages/pt_BR/Zend_Captcha.php', 'default', 'pt_BR');
        AbstractValidator::setDefaultTranslator(new \Zend\Mvc\I18n\Translator($translator));

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()->attach('Zend\View\Helper\Navigation\AbstractHelper', 'isAllowed', array(
            '\Application\Listener\RbacListener',
            'accept'
        ));
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $t = $e->getTarget();

        $t->getEventManager()->attach($t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy'));
        /*
         * $t->getEventManager()->attach($t->getServiceManager()->get('ZfcRbac\View\Strategy\UnauthorizedStrategy'));
         */
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__
                )
            )
        );
    }
}
