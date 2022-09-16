<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Carbon;

use App\Model\Klien;
use App\Model\Pengurusanjasa;
use App\Model\Dokumenklien;

class ListController extends Controller
{

    public function listKlien() {
        return Klien::select('id','nama_lengkap_klien')->get();
    }

    public function listPengurusanjasa() {
        return Pengurusanjasa::select('id','nama_pengurusan')->get();
    }

    public function listDokumenklien() {
        return Dokumenklien::select('id','nama_dokumen_klien')->get();
    }

}
