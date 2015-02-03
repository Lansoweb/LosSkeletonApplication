<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Cliente for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\Console;
use Zend\Console\ColorInterface as Color;
use Zend\Console\Exception\RuntimeException as ConsoleException;
use Zend\Console\Prompt\Line;
use Zend\Console\Prompt\Confirm;
use Usuario\Entity\Usuario;
use Zend\Crypt\Password\Bcrypt;
use LosBase\Entity\EntityManagerAwareTrait;
use Zend\Console\Prompt\Select;

class ConsoleController extends AbstractActionController
{
    use EntityManagerAwareTrait;

    public function novoAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('Esta ação só pode ser utilizada pelo console!');
        }

        try {
            $console = Console::getInstance();
        } catch (ConsoleException $e) {
            throw new \RuntimeException('Esta ação só pode ser utilizada pelo console!');
        }

        $nome = Line::prompt(
            'Qual o nome? ',
            false,
            100
        );

        $email = Line::prompt(
            "Qual o email? ",
            false,
            100
        );

        $senha = Line::prompt(
            'Qual a senha? ',
            false,
            100
        );

        $permissao = Select::prompt('Selecione a permissao:', [
            'admin',
            'usuario'
        ]);

        if ( Confirm::prompt('Confirma a criação do novo usuario? [s/n] ', 's', 'n') ) {
            $usuario = new Usuario();
            //$usuario->setLogin($login);
            $usuario->setEmail($email);
            $usuario->setNome($nome);
            $usuario->setPermissao($permissao == 1 ? 'usuario' : 'admin');

            $options = $this->getServiceLocator()->get('zfcuser_module_options');

            $bcrypt = new Bcrypt();
            $bcrypt->setCost($options->getPasswordCost());
            $usuario->setPassword($bcrypt->create($senha));

            $this->getEntityManager()->persist($usuario);
            $this->getEntityManager()->flush();

            $console->writeLine("Usuário criado.", Color::GREEN);
        }
    }

    public function mudaSenhaAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('Esta ação só pode ser utilizada pelo console!');
        }

        try {
            $console = Console::getInstance();
        } catch (ConsoleException $e) {
            throw new \RuntimeException('Esta ação só pode ser utilizada pelo console!');
        }

        $email = Line::prompt(
            "\nQual o email? ",
            false,
            100
        );

        $senha = Line::prompt(
            'Qual a nova senha? ',
            false,
            100
        );

        $usuario = $this->getEntityManager()->getRepository('Usuario\Entity\Usuario')->findOneBy(['email'=>$email]);

        if (!$usuario) {
            throw new \InvalidArgumentException('Usuário não encontrado!');
        }

        if ( Confirm::prompt('Confirma a alteração da senha? [y/n] ', 'y', 'n') ) {

            $options = $this->getServiceLocator()->get('zfcuser_module_options');

            $bcrypt = new Bcrypt();
            $bcrypt->setCost($options->getPasswordCost());
            $usuario->setPassword($bcrypt->create($senha));

            $this->getEntityManager()->persist($usuario);
            $this->getEntityManager()->flush();

            $console->writeLine("Senha alterada.", Color::GREEN);
        }
    }

}
