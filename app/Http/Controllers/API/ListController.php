<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Carbon;

use App\Model\Klien;
use App\Model\Pengurusanjasa;

class ListController extends Controller
{

    public function listKegiatan() {
        return DB::table('kegiatans')->select('id','nama_kegiatan')->get();
    }

    public function listRT() {
        return DB::table('rt')->select('id','nomor_rt')->get();
    }

    public function listKlien() {
        return Klien::select('id','nama_lengkap_klien')->get();
    }

    public function listPengurusanjasa() {
        return Pengurusanjasa::select('id','nama_pengurusan')->get();
    }

}
