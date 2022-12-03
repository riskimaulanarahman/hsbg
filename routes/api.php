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

Route::apiResource('/bukutamu', 'BukuTamuController');
Route::apiResource('/kelengkapandokumen', 'KelengkapanDokController');
Route::apiResource('/riwayatproses', 'RiwayatProsesController');
Route::apiResource('/riwayatpembayaran', 'RiwayatPembayaranController');


Route::apiResource('logsuccess',  'API\LogSuccessController');
Route::apiResource('logerror',  'API\LogErrorController');

Route::post('/upload-berkas', 'BerkasController@update')->name('uploadberkas');

//master user

//list
Route::post('list-klien', 'API\ListController@listKlien');
Route::post('list-karyawan', 'API\ListController@listKaryawan');
Route::post('list-pengurusanjasa', 'API\ListController@listPengurusanjasa');
Route::post('list-dokumenklien', 'API\ListController@listDokumenklien');
Route::post('list-tahapanproses', 'API\ListController@listTahapanproses');
Route::post('list-uraianbayar', 'API\ListController@listUraianbayar');
Route::post('list-jenistransaksi', 'API\ListController@listJenistransaksi');

//cetak PDF
// Route::get('/cetak-kegiatan/{bulan}/{tahun}/{rt}','KegiatanLaporanController@cetakkegiatan')->name('cetak-kegiatan');