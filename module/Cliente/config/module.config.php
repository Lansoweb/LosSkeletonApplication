<?php
return [
    'controllers' => [
        'invokables' => [
            'Cliente\Controller\Crud' => 'Cliente\Controller\CrudController'
        ]
    ],
    'router' => [
        'routes' => [
            'cliente' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/cliente',
                    'defaults' => [
                        'controller' => 'Cliente\Controller\Crud',
                        'action' => 'list'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'list' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/list',
                            'defaults' => [
                                'controller' => 'Cliente\Controller\Crud',
                                'action' => 'list'
                            ]
                        ]
                    ],
                    'add' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => 'Cliente\Controller\Crud',
                                'action' => 'add'
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/edit[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => 'Cliente\Controller\Crud',
                                'action' => 'edit',
                                'id' => 0
                            ]
                        ]
                    ],
                    'delete' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/delete[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => 'Cliente\Controller\Crud',
                                'action' => 'delete',
                                'id' => 0
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Cliente' => __DIR__ . '/../view'
        ]
    ],
    'doctrine' => [
        'driver' => [
            'Cliente_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Cliente/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Cliente\Entity' => 'Cliente_driver'
                ]
            ]
        ]
    ],
    'navigation' => [
        'default' => [
            'cadastro' => [
                'pages' => [
                    'cliente' => [
                        'label' => 'Cliente',
                        'route' => 'cliente/list',
                        'pages' => [
                            'list' => [
                                'label' => 'List',
                                'route' => 'cliente/list'
                            ],
                            'add' => [
                                'label' => 'Add',
                                'route' => 'cliente/add'
                            ],
                            'edit' => [
                                'label' => 'Edit',
                                'route' => 'cliente/edit'
                            ],
                            'delete' => [
                                'label' => 'Delete',
                                'route' => 'cliente/delete'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];