<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LosBase\Entity\EntityManagerAwareTrait;
use Doctrine\ORM\QueryBuilder;

class IndexController extends AbstractActionController
{
    use EntityManagerAwareTrait;

    public function indexAction()
    {
        return $this->redirect()->toRoute('dashboard');
    }

    public function dashboardAction()
    {
    }
}
