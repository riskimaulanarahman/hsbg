<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Daftarpengurusan;
use App\Model\Riwayatproses;
use App\Model\Tahapanproses;
use Auth;


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
            $user = Auth::user();
            $wuser = ($user->role !== 'staff') ? [] : [['daftar_pengurusan.createdby','=',$user->id]];
            $data = Daftarpengurusan::selectRaw('
                daftar_pengurusan.id,
                daftar_pengurusan.createdby,
                daftar_pengurusan.status_aktif,
                daftar_pengurusan.id_klien,
                daftar_pengurusan.id_ref_pengurusan_jasa,
                daftar_pengurusan.tanggal_daftar_pengurusan,
                daftar_pengurusan.status_lunas,
                daftar_pengurusan.status_selesai,
                daftar_pengurusan.total_biaya_daftar_pengurusan,
                sum(riwayat_pembayaran.jumlah_pembayaran) as total_jumlah_yang_dibayar
            ')
            ->with('createdby', 'klien', 'pengurusanjasa')
            ->leftJoin('riwayat_pembayaran', 'riwayat_pembayaran.id_daftar_pengurusan','daftar_pengurusan.id')
            ->where('daftar_pengurusan.deleted_status', 0)
            ->where($wuser)
            ->groupBy(
                'daftar_pengurusan.id',
                'daftar_pengurusan.createdby',
                'daftar_pengurusan.status_aktif',
                'daftar_pengurusan.id_klien',
                'daftar_pengurusan.id_ref_pengurusan_jasa',
                'daftar_pengurusan.tanggal_daftar_pengurusan',
                'daftar_pengurusan.status_lunas',
                'daftar_pengurusan.status_selesai',
                'daftar_pengurusan.total_biaya_daftar_pengurusan'
            )
            ->get();

            return response()->json(['status' => "show", "message" => "Menampilkan Data" , 'data' => $data])->setEncodingOptions(JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {

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

                $getproses = Tahapanproses::where('id_ref_pengurusan_jasa', $request->id_ref_pengurusan_jasa)
                ->orderBy('nomor_urut_tahapan_proses')
                ->get();
                
                if (count($getproses) > 0) {

                    $getexistdata = Daftarpengurusan::with('klien','pengurusanjasa')
                    ->where('id_klien', $request->id_klien)
                    ->where('id_ref_pengurusan_jasa', $request->id_ref_pengurusan_jasa)
                    ->where('status_selesai', 1)
                    ->where('deleted_status', 0)
                    ->first();

                    if ($getexistdata) {

                        if ($request->mode == 'ignore') {

                            $daftar = Daftarpengurusan::create($requestData);
                            
                            $daftarid = $daftar->id;
                            if ($daftarid !== null) {
                                foreach ($getproses as $proses) {
                                    $data = new Riwayatproses;
                                    $data->id_daftar_pengurusan = $daftarid;
                                    $data->id_ref_tahapan_proses = $proses->id;
                                    $data->save();
                                }
                            }

                            return response()->json(["status" => "success", "message" => "Berhasil Menambahkan Data", "data" => $daftar]);

                        } else {

                            return response()->json(["status" => "prompt", "data"=>$getexistdata ]);
                        }

                    } else {
                        $daftar = Daftarpengurusan::create($requestData);
                            
                            $daftarid = $daftar->id;
                            if ($daftarid !== null) {
                                foreach ($getproses as $proses) {
                                    $data = new Riwayatproses;
                                    $data->id_daftar_pengurusan = $daftarid;
                                    $data->id_ref_tahapan_proses = $proses->id;
                                    $data->save();
                                }
                            }
                        return response()->json(["status" => "success", "message" => "Berhasil Menambahkan Data", "data" => $daftar]);
                        
                    }

                } else {
                    return response()->json(["status" => "error", "message" => "Tahapan Proses Tidak DiTemukan Untuk Jenis Jasa Tersebut", "data" => null]);
                }


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

            if ($request->status_selesai == 0) {
                $getriwayatproses = Riwayatproses::where('id_daftar_pengurusan', $id)
                ->where('status_proses_selesai', 0)
                ->get();
                
                if (count($getriwayatproses) == 0) {
                    
                    $data->update($requestData);
                    $data->save();
                    
                } else {
                    return response()->json(["status" => "error", "message" => "Semua Proses Belum Selesai! Tidak Bisa Merubah Status", "data" => null]);
                }
            } else {
                $data->update($requestData);
                $data->save();
            }

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
