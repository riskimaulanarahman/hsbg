<?php

use Illuminate\Support\Facades\Route;

Route::get('/optimize', function () {
    // Artisan::call('cache:clear');
    // Artisan::call('config:clear');
    Artisan::call('optimize');
    return 'DONE'; //Return anything
});

Route::group(['as' => 'menu.','middleware' => ['auth']], function () {

    Route::get('/', 'HomeController@index')->name('index');

    // todo : referensi
    Route::group(['prefix' => 'referensi','as' => 'referensi.'], function () {
        Route::get('/status', 'MainController@refstatus')->name('status');
        Route::get('/mitra', 'MainController@refmitra')->name('mitra');
        // Route::get('/jenis-transaksi-perusahaan', 'MainController@refjenistransaksiperusahaan')->name('jenistransaksiperusahaan');
        // Route::get('/pengurusan-jasa', 'MainController@refpengurusanjasa')->name('pengurusanjasa');
        // Route::get('/tahapan-proses', 'MainController@reftahapanproses')->name('tahapanproses');
        // Route::get('/uraian-bayar', 'MainController@refuraianbayar')->name('uraianbayar');
        // Route::get('/kontak-lembaga', 'MainController@refkontaklembaga')->name('kontaklembaga');
    }); 
    // ! referensi
    
    // todo : kelola sistem
    Route::group(['prefix' => 'kelola','as' => 'kelola.'], function () {
        Route::get('/user', 'MainController@kelolauser')->name('user');
        // Route::get('/klien', 'MainController@kelolaklien')->name('klien');
        // Route::get('/karyawan', 'MainController@kelolakaryawan')->name('karyawan');
    }); 
    // ! kelola sistem
    
    Route::get('/project', 'MainController@project')->name('project');
    // Route::get('/bantuan', 'MainController@bantuan')->name('bantuan');
    // Route::get('/bukutamu', 'MainController@bukutamu')->name('bukutamu');
    // Route::get('/keuangan-perusahaan', 'MainController@keuanganperusahaan')->name('keuanganperusahaan');
    
    // todo : api
    Route::group(['prefix' => 'api'], function () {

            Route::apiResource('/project', 'ProjectController');

        // referensi
            Route::apiResource('/refstatus', 'referensi\StatusController');
            Route::apiResource('/refmitra', 'referensi\MitraController');
            // Route::apiResource('/jenistransaksiperusahaan', 'referensi\JenistransaksiperusahaanController');
            // Route::apiResource('/pengurusanjasa', 'referensi\PengurusanjasaController');
            // Route::apiResource('/tahapanproses', 'referensi\TahapanprosesController');
            // Route::apiResource('/uraianbayar', 'referensi\UraianbayarController');
            // Route::apiResource('/kontaklembaga', 'referensi\KontaklembagaController');
        // kelola  
            Route::apiResource('/kelola-user', 'kelola\UserController');
            // Route::apiResource('/kelola-klien', 'kelola\KlienController');
            // Route::apiResource('/kelola-karyawan', 'kelola\KaryawanController');
            
            // Route::apiResource('/keuanganperusahaan', 'KeuanganperusahaanController');

    }); 

    // ! api

    
});

require __DIR__.'/auth.php';
