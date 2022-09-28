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
        try {
            $data = Riwayatproses::where('deleted_status',0)->get();

            return response()->json(['status' => "show", "message" => "Menampilkan Data" , 'data' => $data]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->tgl_mulai_riwayat_proses;
        $fixed = date('Y-m-d', strtotime(substr($date,0,10)));
        $date2 = $request->tgl_akhir_riwayat_proses;
        $fixed2 = date('Y-m-d', strtotime(substr($date2,0,10)));
        
        $requestData = $request->all();
        $requestData['tgl_mulai_riwayat_proses'] = $fixed;
        $requestData['tgl_akhir_riwayat_proses'] = $fixed2;
        try {
            if($request->mode == 'addjasa') {
                $getproses = Tahapanproses::where('id_ref_pengurusan_jasa',$request->jasaid)->get();
                if(count($getproses) > 0) {
                    foreach($getproses as $proses) {
                        $data = new Riwayatproses;
                        $data->id_daftar_pengurusan = $request->daftarid;
                        $data->id_ref_tahapan_proses = $proses->id;
                        $data->save();
                    }
                } else {
                    return response()->json(["status" => "error", "message" => "No Data Referensi"]);
                }
            } else if($request->mode == 'newjasa') {
                Riwayatproses::create($requestData);
            }
            return response()->json(["status" => "success", "message" => "Berhasil Menambahkan Data"]);

        } catch (\Exception $e){

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
        $date = $request->tanggal_penyerahan;
        $fixed = date('Y-m-d', strtotime(substr($date,0,10)));
        
        $requestData = $request->all();
        $requestData['tanggal_penyerahan'] = $fixed;
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
        try {
            $data = Riwayatproses::findOrFail($id);
            $data->deleted_status = 1;
            $data->save();
            return response()->json(["status" => "success", "message" => "Berhasil Hapus Data"]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
