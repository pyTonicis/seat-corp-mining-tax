<?php
/*
 *  Menu Configuration
 */
return [
    'corpminingtax' => [
        'name' => 'menu-entry-name',
        'label' => 'corpminingtax::menu.main_level',
        'plural' => true,
        'icon' => 'fas fa-certificate',
        'route_segment' => 'corpminingtax',
        'permission' => 'corpminingtax.view',
        'entries' => [
            [
                'name' => 'corpminingtax-home-sub-menu',
                'label' => 'corpminingtax::menu.sub-home-level',
                'icon' => 'fas fa-home',
                'route' => 'corpminingtax.home',
                'permission' => 'corpminingtax.view'
            ],
            [
                'name' => 'corpminingtax-home-mining-log',
                'label' => 'corpminingtax::menu.sub-mining-log',
                'icon' => 'fas fa-table',
                'route' => 'corpminingtax.logbook',
                'permission' => 'corpminingtax.view'
            ],
            [
                'name' => 'corpminingtax-sub-mining-tax',
                'label' => 'corpminingtax::menu.sub-mining-tax',
                'icon' => 'fas fa-money-bill-wave',
                'route' => 'corpminingtax.tax',
                'permission' => 'corpminingtax.manager'
            ],
            [
                'name' => 'corpminingtax-sub-refining',
                'label' => 'corpminingtax::menu.sub-refining',
                'icon' => 'fas fa-hammer',
                'route' => 'corpminingtax.refining',
                'permission' => 'corpminingtax.view'
            ],
            [
                'name' => 'corpminingtax-sub-corp-moon-mining',
                'label' => 'corpminingtax::menu.sub-corp-moon-mining',
                'icon' => 'fas fa-moon',
                'route' => 'corpminingtax.corpmoonmining',
                'permission' => 'corpminingtax.manager'
            ],
            [
                'name' => 'corpminingtax-sub-tax-contracts',
                'label' => 'corpminingtax::menu.sub-tax-contracts',
                'icon' => 'fas fa-th-list',
                'route' => 'corpminingtax.contracts',
                'permission' => 'corpminingtax.settings'
            ],
            [
                'name' => 'corpminingtax-sub-mining-events',
                'label' => 'corpminingtax::menu.sub-mining-events',
                'icon' => 'fas fa-calendar-alt',
                'route' => 'corpminingtax.events',
                'permission' => 'corpminingtax.settings'
            ],
            [
                'name' => 'corpminingtax-sub-statistics',
                'label' => 'corpminingtax::menu.sub-statistics',
                'icon' => 'fas fa-chart-area',
                'route' => 'corpminingtax.statistics',
                'permission' => 'corpminingtax.settings'
            ],
            [
                'name' => 'corpminingtax-sub-settings-menu',
                'label' => 'corpminingtax::menu.sub-settings',
                'icon' => 'fas fa-cogs',
                'route' => 'corpminingtax.settings',
                'permission' => 'corpminingtax.settings'
            ],
            [
                'name' => 'corpminingtax-sub-thieves',
                'label' => 'corpminingtax::menu.sub-thieves',
                'icon' => 'fas fa-user',
                'route' => 'corpminingtax.thieves',
                'permission' => 'corpminingtax.settings'
            ],
        ],
    ],
];