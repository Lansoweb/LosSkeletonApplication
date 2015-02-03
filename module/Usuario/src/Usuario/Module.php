<?php
namespace Usuario;

use LosBase\Module\AbstractModule;
use ZfcUser\Entity\UserInterface as ZfcUserInterface;
use Zend\Crypt\Password\Bcrypt;

class Module extends AbstractModule
{

    public function onBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $em = $sm->get('Doctrine\ORM\EntityManager');
        $events = $e->getApplication()
            ->getEventManager()
            ->getSharedManager();

        $events->attach('ZfcUser\Authentication\Adapter\AdapterChain', 'authenticate.success', function ($e) use ($sm, $em) {
            $usuario_id = $e->getIdentity();
            $em = $sm->get('Doctrine\ORM\EntityManager');
            $usuario = $sm->get('Doctrine\ORM\EntityManager')->getRepository('Usuario\Entity\Usuario')->find($usuario_id);

            $ip = \LosBase\Service\Util::getIP();
            $agente = \LosBase\Service\Util::getUserAgent();

            $acesso = new Entity\Acesso();
            $acesso->setUsuario($usuario);
            $acesso->setIp($ip);
            $acesso->setAgente($agente);
            $em->persist($acesso);
            $em->flush();
        });

        $events->attach('ZfcUser\Form\LoginFilter', 'init', function ($e) use ($sm, $em) {
            $form = $e->getTarget();
            $form->remove('credential');
            $form->add(array(
                'name'       => 'credential',
                'required'   => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 3,
                        ),
                    ),
                ),
                'filters'   => array(
                    array('name' => 'StringTrim'),
                ),
            ));
        });

        $events->attach('Usuario\Service\Usuario','save', function ($e) use ($sm, $em) {

            $usuario = $e->getParam('entity');
            $form = $e->getParam('form');

            if (!($usuario instanceof ZfcUserInterface)) {
                return;
            }

            if ($form->has('password')) {
                $senha = $form->get('password')->getValue();
                if (!empty($senha)) {
                    $bcrypt = new Bcrypt();
                    $options = $sm->get('zfcuser_module_options');
                    $bcrypt->setCost($options->getPasswordCost());
                    $pass = $bcrypt->create($senha);
                    $usuario->setPassword($pass);
                }
            }
        });
    }

}
