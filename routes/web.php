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
    
    // todo : kelola sistem
    Route::group(['prefix' => 'kelola','as' => 'kelola.'], function () {
        Route::get('/user', 'MainController@kelolauser')->name('user');
    }); 
    // ! kelola sistem
    
    Route::get('/masterssh', 'MainController@masterssh')->name('masterssh');
    Route::get('/simulasi', 'MainController@simulasi')->name('simulasi');
    
    // todo : api
    Route::group(['prefix' => 'api'], function () {
        
        Route::apiResource('/masterssh', 'MastersshController');
        Route::apiResource('/simulasi', 'SimulasiController');
        Route::get('/listmasterssh', 'MainController@listmasterssh');
        Route::get('/getmasterssh/{id}', 'MainController@getmasterssh')->name('getmasterssh');

        // kelola  
            Route::apiResource('/kelola-user', 'kelola\UserController');

    }); 

    // ! api

    
});

require __DIR__.'/auth.php';
