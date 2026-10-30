<?php

return [
    'dashboard' => [
        'module_name' => 'Dashboard',
        'routes' => [
            'dashboard' => [
                'method_name' => 'Access dashboard',
                'route' => 'admin.dashboard.index',
            ],
        ],
        'order' => 1
    ],

    'projects' => [
        'module_name' => 'Projects',
        'routes' => [
            'index' => ['method_name' => 'View list', 'route' => 'admin.projects.index'],
            'create' => ['method_name' => 'Create', 'route' => 'admin.projects.create'],
            'edit' => ['method_name' => 'Edit', 'route' => 'admin.projects.edit'],
            'destroy' => ['method_name' => 'Delete', 'route' => 'admin.projects.destroy'],
        ],
        'order' => 2,
    ],

    'ecom_products' => [
        'module_name' => 'E-Commerce Products',
        'routes' => [
            'index' => ['method_name' => 'View list', 'route' => 'admin.ecom_products.index'],
            'create' => ['method_name' => 'Create', 'route' => 'admin.ecom_products.create'],
            'edit' => ['method_name' => 'Edit', 'route' => 'admin.ecom_products.edit'],
            'destroy' => ['method_name' => 'Delete', 'route' => 'admin.ecom_products.destroy'],
        ],
        'order' => 10,
    ],

    'ecom_orders' => [
        'module_name' => 'E-Commerce Orders',
        'routes' => [
            'index' => ['method_name' => 'View list', 'route' => 'admin.ecom_orders.index'],
            'create' => ['method_name' => 'Create', 'route' => 'admin.ecom_orders.create'],
            'edit' => ['method_name' => 'Edit', 'route' => 'admin.ecom_orders.edit'],
            'destroy' => ['method_name' => 'Delete', 'route' => 'admin.ecom_orders.destroy'],
        ],
        'order' => 11,
    ],

    'services' => [
        'module_name' => 'Services',
        'routes' => [
            'index' => ['method_name' => 'View list', 'route' => 'admin.services.index'],
            'create' => ['method_name' => 'Create', 'route' => 'admin.services.create'],
            'edit' => ['method_name' => 'Edit', 'route' => 'admin.services.edit'],
            'destroy' => ['method_name' => 'Delete', 'route' => 'admin.services.destroy'],
        ],
        'order' => 3,
    ],

    'news' => [
        'module_name' => 'News',
        'routes' => [
            'index' => ['method_name' => 'View list', 'route' => 'admin.news.index'],
            'create' => ['method_name' => 'Create', 'route' => 'admin.news.create'],
            'edit' => ['method_name' => 'Edit', 'route' => 'admin.news.edit'],
            'destroy' => ['method_name' => 'Delete', 'route' => 'admin.news.destroy'],
        ],
        'order' => 4,
    ],

    'contacts' => [
        'module_name' => 'Enquiries',
        'routes' => [
            'index' => ['method_name' => 'View list', 'route' => 'admin.contacts.index'],
            'edit' => ['method_name' => 'Update status', 'route' => 'admin.contacts.edit'],
        ],
        'order' => 5,
    ],

    'contracts' => [
        'module_name' => 'Service contracts',
        'routes' => [
            'index' => ['method_name' => 'View list', 'route' => 'admin.contracts.index'],
            'create' => ['method_name' => 'Create', 'route' => 'admin.contracts.create'],
            'edit' => ['method_name' => 'Edit and send for signing', 'route' => 'admin.contracts.edit'],
            'destroy' => ['method_name' => 'Delete', 'route' => 'admin.contracts.destroy'],
        ],
        'order' => 6,
    ],

    'users' => [
        'module_name' => 'Users',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.users.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.users.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.users.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.users.destroy',
            ],
        ],
    ],

    'roles' => [
        'module_name' => 'Roles',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.roles.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.roles.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.roles.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.roles.destroy',
            ],
        ],
    ],

    'document-types' => [
        'module_name' => 'Document types',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.document-types.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.document-types.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.document-types.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.document-types.destroy',
            ],
        ],
    ],

    'report-types' => [
        'module_name' => 'Report types',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.report-types.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.report-types.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.report-types.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.report-types.destroy',
            ],
        ],
    ],

    'provinces' => [
        'module_name' => 'Province/City',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.provinces.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.provinces.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.provinces.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.provinces.destroy',
            ],
        ],
    ],

    'districts' => [
        'module_name' => 'District',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.districts.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.districts.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.districts.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.districts.destroy',
            ],
        ],
    ],

    'development-milestones' => [
        'module_name' => 'Development milestones',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.development-milestones.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.development-milestones.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.development-milestones.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.development-milestones.destroy',
            ],
        ],
    ],

    'company-histories' => [
        'module_name' => 'Development journey',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.company-histories.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.company-histories.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.company-histories.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.company-histories.destroy',
            ],
        ],
    ],

    'wards' => [
        'module_name' => 'Ward',
        'routes' => [
            'index' => [
                'method_name' => 'View list',
                'route' => 'admin.wards.index',
            ],
            'create' => [
                'method_name' => 'Create',
                'route' => 'admin.wards.create',
            ],
            'edit' => [
                'method_name' => 'Edit',
                'route' => 'admin.wards.edit',
            ],
            'destroy' => [
                'method_name' => 'Delete',
                'route' => 'admin.wards.destroy',
            ],
        ],
    ],
    'systems' => [
        'module_name' => 'System',
        'routes' => [
            'generals' => [
                'method_name' => 'App',
                'route' => 'admin.systems.generals',
            ],
            'pages' => [
                'method_name' => 'Message trang',
                'route' => 'admin.systems.pages',
            ],            'apis' => [
                'method_name' => 'APIs',
                'route' => 'admin.systems.apis',
            ],
            'shareholders' => [
                'method_name' => 'shareholder',
                'route' => 'admin.systems.config-shareholders',
            ],
            'socials' => [
                'method_name' => 'Social media',
                'route' => 'admin.systems.socials',
            ],
            'otps' => [
                'method_name' => 'OTPs',
                'route' => 'admin.systems.otps',
            ],
            'notifications' => [
                'method_name' => 'Notifications',
                'route' => 'admin.systems.notifications',
            ],
            'edit' => [
                'method_name' => 'Update',
                'route' => 'admin.systems.edit',
            ]
        ],
    ],
];
