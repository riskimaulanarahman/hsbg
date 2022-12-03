<?php

namespace App\Http\Controllers\kelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Karyawan;
use Validator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Karyawan::where('deleted_status',0)->get();

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
        $date = $request->tanggal_masuk;
        $fixed = date('Y-m-d', strtotime(substr($date, 0, 10)));

        try {
            // $validator = Validator::make($request->all(), [
            //     'nomor_induk_karyawan' => 'required|unique:karyawan'
            // ]);
            // if ($validator->fails()) {
            //     return response()->json(["status" => "error", "message" => $validator->errors()->first()]);
            // }
            
            $requestData = $request->all();
            $requestData['tanggal_masuk'] = $fixed;

            Karyawan::create($requestData);
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
        //
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
        $date = $request->tanggal_masuk;
        $fixed = date('Y-m-d', strtotime(substr($date, 0, 10)));

        try {
            // $validator = Validator::make($request->all(), [
            //     'nomor_induk_karyawan' => 'required|unique:karyawan'
            // ]);
            // if ($validator->fails()) {
            //     return response()->json(["status" => "error", "message" => $validator->errors()->first()]);
            // }

            $requestData = $request->all();
            $requestData['tanggal_masuk'] = $fixed;
    
            $data = Karyawan::findOrFail($id);
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
        
            $data = Karyawan::findOrFail($id);
            $data->deleted_status = 1;
            $data->save();
            
            return response()->json(["status" => "success", "message" => "Berhasil Hapus Data"]);
            

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
