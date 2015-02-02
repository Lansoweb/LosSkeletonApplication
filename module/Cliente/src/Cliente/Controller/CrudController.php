<?php
namespace Cliente\Controller;

use LosBase\Controller\AbstractCrudController;

class CrudController extends AbstractCrudController
{
    protected $uniqueField = 'nome';
}
