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
use App\Model\Tahapanproses;
use App\Model\Uraianbayar;

class ListController extends Controller
{

    public function listKlien() {
        return Klien::select('id','nama_lengkap_klien')->where('deleted_status',0)->get();
    }

    public function listPengurusanjasa() {
        return Pengurusanjasa::select('id','nama_pengurusan')->where('status_aktif',1)->get();
    }

    public function listDokumenklien() {
        return Dokumenklien::select('id','nama_dokumen_klien')->where('status_aktif',1)->get();
    }

    public function listTahapanproses() {
        return Tahapanproses::select('id','nama_tahapan_proses')->where('status_aktif',1)->get();
    }

    public function listUraianbayar() {
        return Uraianbayar::select('id','uraian_bayar')->where('status_aktif',1)->get();
    }

}
