<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Riwayatpembayaran;

class RiwayatPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ..
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->tanggal_pembayaran;
        $fixed = date('Y-m-d', strtotime(substr($date, 0, 10)));
        
        $requestData = $request->all();
        if ($date) {
            $requestData['tanggal_pembayaran'] = $fixed;
        }
        try {
            Riwayatpembayaran::create($requestData);

            return response()->json(["status" => "success", "message" => "Berhasil Menambahkan Data"]);

        } catch (\Exception $e) {

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $data = Riwayatpembayaran::with('uraianbayar')
            ->where('id_daftar_pengurusan',$id)
            ->get();

            return response()->json(['status' => "show", "message" => "Menampilkan Data" , 'data' => $data]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $date = $request->tanggal_pembayaran;
        $fixed = date('Y-m-d', strtotime(substr($date,0,10)));
        
        $requestData = $request->all();
        // ($request->status_cek_pembayaran == 'false') ? $requestData['status_cek_pembayaran'] = 0 : $requestData['status_cek_pembayaran'] = 1;
        if($date) {
            $requestData['tanggal_pembayaran'] = $fixed;
        }

        try {
    
            $data = Riwayatpembayaran::findOrFail($id);
            $data->update($requestData);
            $data->save();

            return response()->json(["status" => "success", "message" => "Berhasil Ubah Data"]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Riwayatpembayaran::findOrFail($id);
            // $data->deleted_status = 1;
            $data->delete();
            // $data->save();
            return response()->json(["status" => "success", "message" => "Berhasil Hapus Data"]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
