<?php

use Illuminate\Support\Facades\Route;

Route::group( ['as' => 'menu.','middleware' => ['auth']], function() {

    Route::get('/', 'HomeController@index')->name('index');

    // todo : referensi
    Route::group( ['prefix' => 'referensi','as' => 'referensi.'], function() {
        Route::get('/dokumen-klien','MainController@refdokumenklien')->name('dokumenklien');
        Route::get('/jenis-biaya-perusahaan','MainController@refjenisbiayaperusahaan')->name('jenisbiayaperusahaan');
        Route::get('/pengurusan-jasa','MainController@refpengurusanjasa')->name('pengurusanjasa');
        Route::get('/tahapan-proses','MainController@reftahapanproses')->name('tahapanproses');
        Route::get('/uraian-bayar','MainController@refuraianbayar')->name('uraianbayar');
        Route::get('/kontak-lembaga','MainController@refkontaklembaga')->name('kontaklembaga');
    }); 
    // ! referensi
    
    // todo : kelola sistem
    Route::group( ['prefix' => 'kelola','as' => 'kelola.'], function() {
        Route::get('/user','MainController@kelolauser')->name('user');
        Route::get('/klien','MainController@kelolaklien')->name('klien');
    }); 
    // ! kelola sistem
    
    Route::get('/dokumen', 'MainController@dokumen')->name('dokumen');
    Route::get('/bantuan', 'MainController@bantuan')->name('bantuan');
    
    // todo : api
    Route::group( ['prefix' => 'api'], function() {

            // Route::apiResource('/dokumen','DokumenController');
        // referensi
            Route::apiResource('/dokumenklien','referensi\DokumenklienController');
            Route::apiResource('/jenisbiayaperusahaan','referensi\JenisbiayaperusahaanController');
            Route::apiResource('/pengurusanjasa','referensi\PengurusanjasaController');
            Route::apiResource('/tahapanproses','referensi\TahapanprosesController');
            Route::apiResource('/uraianbayar','referensi\UraianbayarController');
            Route::apiResource('/kontaklembaga','referensi\KontaklembagaController');
        // kelola  
            Route::apiResource('/kelola-user','kelola\UserController');
            Route::apiResource('/kelola-klien','kelola\KlienController');

    }); 

    // ! api

    
});

require __DIR__.'/auth.php';
