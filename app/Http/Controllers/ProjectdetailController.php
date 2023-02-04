<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Projectdetail;
use App\Model\RefStatus;

class ProjectdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $data = Projectdetail::get();

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
        try {
            
            $date = $request->tanggal;
            $fixed = date('Y-m-d', strtotime(substr($date, 0, 10)));
            
            $requestData = $request->all();
            if ($date) {
                $requestData['tanggal'] = $fixed;
            }

            if ($request->sub_status) {
                $getstatus = RefStatus::where('substatus', $request->sub_status)->first();
                $requestData['status'] = $getstatus->status;
            }

            Projectdetail::create($requestData);

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

            $data = Projectdetail::where('project_id', $id)
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
        try {
            
            $date = $request->tanggal;
            $fixed = date('Y-m-d', strtotime(substr($date, 0, 10)));
            
            $requestData = $request->all();
            if ($date) {
                $requestData['tanggal'] = $fixed;
            }
            
            if ($request->sub_status) {
                $getstatus = RefStatus::where('substatus', $request->sub_status)->first();
                $requestData['status'] = $getstatus->status;
            }
    
            $data = Projectdetail::findOrFail($id);
            $data->update($requestData);

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

            $data = Projectdetail::findOrFail($id);
            $data->delete();

            return response()->json(["status" => "success", "message" => "Berhasil Hapus Data"]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
