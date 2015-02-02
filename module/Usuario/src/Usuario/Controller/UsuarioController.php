<?php
namespace Usuario\Controller;

use LosBase\Controller\AbstractCrudController;

class UsuarioController extends AbstractCrudController
{
    protected $uniqueField = 'email';

    public function getEditForm()
    {
        $form = parent::getEditForm();

        $form->get('password')->setLabel('Nova Senha');

        $inputFilter = $form->getInputFilter();
        $inputFilter->get('password')->setRequired(false);
        $inputFilter->get('confirmesenha')->setRequired(false);

        return $form;
    }
}
