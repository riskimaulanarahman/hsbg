<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/projectdetail', 'ProjectdetailController');
// Route::apiResource('/riwayatproses', 'RiwayatProsesController');
// Route::apiResource('/riwayatpembayaran', 'RiwayatPembayaranController');


Route::apiResource('logsuccess',  'API\LogSuccessController');
Route::apiResource('logerror',  'API\LogErrorController');

Route::post('/upload-berkas', 'BerkasController@update')->name('uploadberkas');

//master user

//list
Route::post('list-mitra', 'API\ListController@listMitra');
Route::post('list-substatus', 'API\ListController@listsubStatus');
Route::get('totalspchart', 'API\ListController@totalSPchart');
Route::get('totalsp', 'API\ListController@totalSP');

Route::get('/listmastersshhome', 'MainController@listmasterssh');
Route::apiResource('/simulasihome', 'SimulasiController');
Route::get('/getmastersshhome/{id}', 'MainController@getmasterssh')->name('getmasterssh');



//cetak PDF
// Route::get('/cetak-kegiatan/{bulan}/{tahun}/{rt}','KegiatanLaporanController@cetakkegiatan')->name('cetak-kegiatan');