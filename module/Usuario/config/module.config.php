<?php
namespace Usuario;

return array(
    'controllers' => array(
        'invokables' => array(
            'usuario' => 'Usuario\Controller\UsuarioController',
            'usuario-console' => 'Usuario\Controller\ConsoleController'
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'usuario-novo' => array(
                    'options' => array(
                        'route'    => 'usuario novo',
                        'defaults' => array(
                            'controller' => 'usuario-console',
                            'action'     => 'novo'
                        )
                    )
                ),
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'usuario' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/usuario',
                    'defaults' => array(
                        'controller' => 'usuario',
                        'action' => 'login'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'login'
                            )
                        )
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'zfcuser',
                                'action' => 'logout'
                            )
                        )
                    ),
                    'list' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/list',
                            'defaults' => array(
                                'controller' => 'usuario',
                                'action' => 'list'
                            )
                        )
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'usuario',
                                'action' => 'edit',
                                'id' => 0
                            )
                        )
                    ),
                    'add' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'controller' => 'usuario',
                                'action' => 'add',
                            )
                        )
                    )
                )
            )
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'usuario' => __DIR__ . '/../view'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'navigation' => array(
        'default' => array(
            'cadastro' => array(
                'pages' => array(
                    'usuario' => array(
                        'label' => 'Usuários',
                        'id' => 'usuario',
                        'route' => 'usuario/list',
                        'permission' => 'admin',
                        'pages' => array(
                            'list' => array(
                                'label' => 'Cadastrados',
                                'route' => 'usuario/list'
                            ),
                            'edit' => array(
                                'label' => 'Alterar',
                                'route' => 'usuario/edit'
                            ),
                            'add' => array(
                                'label' => 'Inserir',
                                'route' => 'usuario/add'
                            ),
                            'delete' => array(
                                'label' => 'Excluir',
                                'route' => 'usuario/delete'
                            )
                        )
                    )
                )
            )
        )
    )
);
