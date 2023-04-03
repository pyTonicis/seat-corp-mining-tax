<?php

/*
This file is part of SeAT

Copyright (C) 2015 to 2020  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
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
                'icon' => 'fas fa-house',
                'route' => 'corpminingtax.home',
                'permission' => 'corpminingtax.view'
            ],
            [
                'name' => 'corpminingtax-sub-mining-tax',
                'label' => 'corpminingtax::menu.sub-mining-tax',
                'icon' => 'fas fa-money-bill-wave',
                'route' => 'corpminingtax.tax',
                'permission' => 'corpminingtax.view'
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
                'permission' => 'corpminingtax.view'
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