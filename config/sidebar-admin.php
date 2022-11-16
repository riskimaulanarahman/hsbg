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
        ],[
            'icon' => 'fa fa-cog',
            'title' => 'Kelola Sistem',
            'url' => 'javascript:;',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/kelola/user',
                    'title' => 'Data Pemakai',
                    'route-name' => 'menu.kelola.user'
                ],
                [
                    'url' => '#',
                    'title' => 'Inisialisasi Kantor',
                    'route-name' => '#'
                ],
                [
                    'url' => '#',
                    'title' => 'Backup Database',
                    'route-name' => '#'
                ]]
        ],[
            'icon' => 'fa fa-list',
            'title' => 'Table Referensi',
            'url' => 'javascript:;',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/referensi/dokumen-klien',
                    'title' => 'Dokumen Klien',
                    'route-name' => 'menu.referensi.dokumenklien'
                ],
                [
                    'url' => '/referensi/kontak-lembaga',
                    'title' => 'Kontak Lembaga',
                    'route-name' => 'menu.referensi.kontaklembaga'
                ],
                [
                    'url' => '/referensi/jenis-transaksi-perusahaan',
                    'title' => 'Jenis Transaksi Perusahaan',
                    'route-name' => 'menu.referensi.jenistransaksiperusahaan'
                ],
                [
                    'url' => '/referensi/pengurusan-jasa',
                    'title' => 'Pengurusan Jasa',
                    'route-name' => 'menu.referensi.pengurusanjasa'
                ],
                [
                    'url' => '/referensi/tahapan-proses',
                    'title' => 'Tahapan Proses',
                    'route-name' => 'menu.referensi.tahapanproses'
                ],
                [
                    'url' => '/referensi/uraian-bayar',
                    'title' => 'Uraian Bayar',
                    'route-name' => 'menu.referensi.uraianbayar'
                ],
            ]
        ],
        // [
        //     'icon' => 'fa fa-tools',
        //     'title' => 'Tools',
        //     'url' => 'javascript:;',
        //     'caret' => true,
        //     'sub_menu' => [
        //         [
        //             'url' => '#',
        //             'title' => 'Atur Notifikasi',
        //             'route-name' => '#'
        //         ],
        //         [
        //             'url' => '/bantuan',
        //             'title' => 'Bantuan',
        //             'route-name' => 'menu.bantuan'
        //         ]]
        // ],
        [
            'icon' => 'fa fa-question-circle',
            'title' => 'Bantuan',
            'url' => 'https://drive.google.com/file/d/13BYeb2GZ0YNbJbnbRaK9tJsyCeJcofkK/view?usp=sharing',
            'route-name' => 'menu.bantuan'
        ],[
            'icon' => 'fa fa-book',
            'title' => 'Lihat Buku Tamu',
            'url' => '/bukutamu',
            'route-name' => 'menu.bukutamu'
        ]
    ]
];
