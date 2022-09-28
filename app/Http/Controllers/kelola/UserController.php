<?php

namespace App\Http\Controllers\kelola;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;


class UserController extends Controller
{

    public function index()
    {
        try {
            $data = User::where('deleted_status',0)->get();

            return response()->json(['status' => "show", "message" => "Menampilkan Data" , 'data' => $data]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'status_aktif' => ($request->status_aktif == 'false') ? 0 : 1
            ]);
            return response()->json(["status" => "success", "message" => "Berhasil Menambahkan Data"]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function show()
    {
        // ! code
    }

    public function update(Request $request, $id)
    {
        try {
            $requestData = $request->all();
            ($request->status_aktif == 'false') ? $requestData['status_aktif'] = 0 : $requestData['status_aktif'] = 1;
            
            $data = User::findOrFail($id);
            $data->update($requestData);
            $data->save();

            if(!empty($request->password)) {
                $data->password = bcrypt($request->password);
                $data->save();
            }
        

            return response()->json(["status" => "success", "message" => "Berhasil Ubah Data"]);

        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = User::findOrFail($id);

            if($data->role == 'admin') {
                return response()->json(["status" => "error", "message" => "Admin Tidak Bisa Dihapus"]);
            } else {
                $data->deleted_status = 1;
                $data->save();
                return response()->json(["status" => "success", "message" => "Berhasil Hapus Data"]);
            }


        } catch (\Exception $e){

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
