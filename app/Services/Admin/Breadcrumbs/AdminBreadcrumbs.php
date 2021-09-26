<?php


namespace App\Services\Admin\Breadcrumbs;

class AdminBreadcrumbs
{
    public function __invoke() : array
    {
        return [
            ADMIN_DASHBOARD_ROUTE => [
                'name' => 'Главная панель',
                'children' => [
                    ADMIN_CLIENTS_INDEX_ROUTE => [
                        'name' => 'Клиенты',
                        'children' => [
                            ADMIN_CLIENTS_EDIT_ROUTE => [
                                'name' => 'Редактирование клиента',
                                'uri' => '',
                            ],
                            ADMIN_CLIENTS_CREATE_ROUTE => [
                                'name' => 'Создание клиента',
                            ],
                        ],
                    ],
                    ADMIN_CATEGORIES_INDEX_ROUTE => [
                        'name' => 'Категории',
                        'children' => [
                            ADMIN_CATEGORIES_EDIT_ROUTE => [
                                'name' => 'Редактирование категории',
                                'uri' => '',
                            ],
                            ADMIN_CATEGORIES_CREATE_ROUTE => [
                                'name' => 'Создание категории',
                            ],
                        ],
                    ],
                    ADMIN_SECTIONS_INDEX_ROUTE => [
                        'name' => 'Разделы',
                        'children' => [
                            ADMIN_SECTIONS_EDIT_ROUTE => [
                                'name' => 'Редактирование раздела',
                                'uri' => '',
                            ],
                            ADMIN_SECTIONS_CREATE_ROUTE => [
                                'name' => 'Создание раздела',
                            ],
                        ],
                    ],
                    ADMIN_SERVICES_INDEX_ROUTE => [
                        'name' => 'Услуги',
                        'children' => [
                            ADMIN_SERVICES_EDIT_ROUTE => [
                                'name' => 'Редактирование услуги',
                                'uri' => '',
                            ],
                            ADMIN_SERVICES_CREATE_ROUTE => [
                                'name' => 'Создание услуги',
                            ],
                        ],
                    ],
                    ADMIN_EMPLOYEES_INDEX_ROUTE => [
                        'name' => 'Сотрудники',
                        'children' => [
                            ADMIN_EMPLOYEES_EDIT_ROUTE => [
                                'name' => 'Редактирование сотрудника',
                                'uri' => '',
                            ],
                            ADMIN_EMPLOYEES_CRETE_ROUTE => [
                                'name' => 'Создание сотрудника',
                            ],
                            ADMIN_EMPLOYEES_WORKING_DAYS_EDIT_ROUTE => [
                                'name' => 'Редактирование графика сотрудника',
                                'uri' => '',
                            ],
                        ],
                    ],
                    ADMIN_VISITS_INDEX_ROUTE => [
                        'name' => 'Визиты',
                        'children' => [
                            ADMIN_VISITS_EDIT_ROUTE => [
                                'name' => 'Редактирование визита',
                                'uri' => '',
                            ],
                            ADMIN_VISITS_CREATE_ROUTE => [
                                'name' => 'Создание визита',
                            ],
                        ],
                    ],
                    ADMIN_POSITIONS_INDEX_ROUTE => [
                        'name' => 'Должности',
                        'children' => [
                            ADMIN_POSITIONS_EDIT_ROUTE => [
                                'name' => 'Редактирование должности',
                                'uri' => '',
                            ],
                            ADMIN_POSITIONS_CREATE_ROUTE => [
                                'name' => 'Создание должности',
                            ],
                        ],
                    ],
                    ADMIN_SETTINGS_GENERAL_EDIT_ROUTE => [
                        'name' => 'Настройки приложения',
                    ],
                    ADMIN_SETTINGS_WORKING_DAYS_EDIT_ROUTE => [
                        'name' => 'График работы',
                    ],
                    ADMIN_SCHEDULE_INDEX_ROUTE => [
                        'name' => 'Расписание',
                    ]
                ]
            ]
        ];
    }
}
