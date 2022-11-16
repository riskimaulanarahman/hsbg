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
            'icon' => 'fa fa-file',
            'title' => 'Master Data',
            'url' => 'javascript:;',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/kelola/klien',
                    'title' => 'Klien',
                    'route-name' => 'menu.kelola.klien'
                ],
                [
                    'url' => '/dokumen',
                    'title' => 'Data Pengurusan',
                    'route-name' => 'menu.dokumen'
                ]]
        ],[
            'icon' => 'fa fa-wallet',
            'title' => 'Keuangan Perusahaan',
            'url' => '/keuangan-perusahaan',
            'route-name' => 'menu.keuanganperusahaan'
        ]
    ]
];
