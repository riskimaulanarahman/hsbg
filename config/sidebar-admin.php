<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */
  'menu' => [
        [
            'icon' => 'fa fa-home',
            'title' => 'Dashboard',
            'url' => '/',
            'route-name' => 'menu.index'
        ],
        [
            'icon' => 'fa fa-book',
            'title' => 'Master Data',
            'url' => 'javascript:;',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/project',
                    'title' => 'Data Project',
                    'route-name' => 'menu.project'
                ]]
        ],[
            'icon' => 'fa fa-list',
            'title' => 'Table Referensi',
            'url' => 'javascript:;',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/referensi/status',
                    'title' => 'Status',
                    'route-name' => 'menu.referensi.status'
                ],
                [
                    'url' => '/referensi/mitra',
                    'title' => 'Mitra',
                    'route-name' => 'menu.referensi.mitra'
                ],
            ]
        ],
        [
            'icon' => 'fa fa-cog',
            'title' => 'Kelola Sistem',
            'url' => 'javascript:;',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/kelola/user',
                    'title' => 'User',
                    'route-name' => 'menu.kelola.user'
                ],
                ]
        ],
    ]
];
