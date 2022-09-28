<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Riwayatproses;
use App\Model\Tahapanproses;

class RiwayatProsesController extends Controller
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
        // ..
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

            $data = Riwayatproses::where('deleted_status',0)
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
        $date = $request->tgl_mulai_riwayat_proses;
        $fixed = date('Y-m-d', strtotime(substr($date,0,10)));
        $date2 = $request->tgl_akhir_riwayat_proses;
        $fixed2 = date('Y-m-d', strtotime(substr($date2,0,10)));
        
        $requestData = $request->all();
        ($request->status_proses_selesai == 'false') ? $requestData['status_proses_selesai'] = 0 : $requestData['status_proses_selesai'] = 1;
        if($date) {
            $requestData['tgl_mulai_riwayat_proses'] = $fixed;
        }
        if($date2) {
            $requestData['tgl_akhir_riwayat_proses'] = $fixed2;
        }

        try {
    
            $data = Riwayatproses::findOrFail($id);
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
        // ..
    }
}
