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
            'icon' => 'fa fa-file-invoice',
            'title' => 'Simulasi',
            'url' => '/simulasi',
            'route-name' => 'menu.simulasi'
        ],
    ]
];
