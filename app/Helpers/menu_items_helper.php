<?php

function menu_items()
{

    return [
        [
            'title'    => 'Dashboard',
            'url'      => base_url('dashboard'),
            'icon'     => 'dashboard',
            'children' => [],
        ],
        [
            'title'    => 'Roles',
            'url'      => base_url('roles'),
            'icon'     => 'user-circle',
            'children' => [],
        ],
        [
            'title'    => 'Users',
            'url'      => base_url('users'),
            'icon'     => 'users',
            'children' => [],
        ],
        [
            'title'    => 'Unit of Measures',
            'url'      => base_url('unit-of-measures'),
            'icon'     => 'ruler-measure',
            'children' => [],
        ],
        [
            'title'    => 'Categories',
            'url'      => base_url('categories'),
            'icon'     => 'sitemap',
            'children' => [],
        ],
        ['title'   => 'Products',
            'url'      => base_url('products'),
            'icon'     => 'list-details',
            'children' => [],

        ],
        ['title'   => 'Outlets',
            'url'      => base_url('outlets'),
            'icon'     => 'list-details',
            'children' => [],

        ], ['title' => 'Customers',
            'url'       => base_url('customers'),
            'icon'      => 'list-details',
            'children'  => [],

        ],
        ['title'   => 'Vendors',
            'url'      => base_url('vendors'),
            'icon'     => 'list-details',
            'children' => [],

        ],
        ['title'   => 'Purchases',
            'url'      => base_url('purchases'),
            'icon'     => 'list-details',
            'children' => [],

        ],
        ['title'   => 'Invoices',
            'url'      => base_url('invoices'),
            'icon'     => 'list-details',
            'children' => [],

        ],
        ['title'   => 'Stocks',
            'url'      => base_url('stocks'),
            'icon'     => 'list-details',
            'children' => [],

        ],
        ['title'   => 'Sales Report',
            'url'      => base_url('reports/sales'),
            'icon'     => 'list-details',
            'children' => [],

        ],
        ['title'   => 'Purchase Report',
            'url'      => base_url('reports/purchase'),
            'icon'     => 'list-details',
            'children' => [],

        ],
        // [
        //     'title'    => 'Parent Menu',
        //     'url'      => 'javascript:void(0)',
        //     'icon'     => 'user-circle',
        //     'children' => [
        //         ['title' => 'Sub Menu 1',
        //             'url'    => base_url('roles'),
        //             'icon'   => 'user-circle',

        //         ],
        //         ['title' => 'Sub Menu 2',
        //             'url'    => base_url('roles'),
        //             'icon'   => 'user-circle',

        //         ],

        //     ],
        // ],
    ];

}
