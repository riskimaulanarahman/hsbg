<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Daftarpengurusan;
use App\Model\Riwayatproses;
use App\Model\Tahapanproses;


class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Daftarpengurusan::with('createdby','klien','pengurusanjasa')->where('deleted_status',0)->get();

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
        $date = $request->tanggal_daftar_pengurusan;
        $fixed = date('Y-m-d', strtotime(substr($date,0,10)));
        
        $requestData = $request->all();
        $requestData['tanggal_daftar_pengurusan'] = $fixed;
        try {
            $getproses = Tahapanproses::where('id_ref_pengurusan_jasa',$request->id_ref_pengurusan_jasa)->get();
            
            if(count($getproses) > 0) {
                $daftar = Daftarpengurusan::create($requestData);

                $daftarid = $daftar->id;
                if($daftarid !== null) {
                    foreach($getproses as $proses) {
                        $data = new Riwayatproses;
                        $data->id_daftar_pengurusan = $daftarid;
                        $data->id_ref_tahapan_proses = $proses->id;
                        $data->save();
                    }
                }
            } else {
                return response()->json(["status" => "error", "message" => "Tahapan Proses Tidak DiTemukan Untuk Jenis Jasa Tersebut", "data" => null]);
            }
            return response()->json(["status" => "success", "message" => "Berhasil Menambahkan Data", "data" => $daftar]);

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

            return Daftarpengurusan::where('id',$id)->first();

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
        $date = $request->tanggal_daftar_pengurusan;
        $fixed = date('Y-m-d', strtotime(substr($date,0,10)));
        
        $requestData = $request->all();
        $requestData['tanggal_daftar_pengurusan'] = $fixed;
        try {
    
            $data = Daftarpengurusan::findOrFail($id);
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
            $data = Daftarpengurusan::findOrFail($id);
            $data->deleted_status = 1;
            $data->save();
            return response()->json(["status" => "success", "message" => "Berhasil Hapus Data"]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
