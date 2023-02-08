<?php
namespace App\Http\Controllers;

use App\Model\Projectdetail;
use DB;

class MainController extends Controller 
{

    public function refstatus() 
    {
        return view('pages.referensi.status');
    }

    public function refmitra() 
    {
        return view('pages.referensi.mitra');
    }

    public function project() 
    {
        return view('pages.project');
    }

    public function refjenistransaksiperusahaan() 
    {
        return view('pages.referensi.jenistransaksiperusahaan');
    }

    public function refpengurusanjasa() 
    {
        return view('pages.referensi.pengurusanjasa');
    }

    public function reftahapanproses() 
    {
        return view('pages.referensi.tahapanproses');
    }

    public function refuraianbayar() 
    {
        return view('pages.referensi.uraianbayar');
    }

    public function refkontaklembaga() 
    {
        return view('pages.referensi.kontaklembaga');
    }

    public function kelolauser() 
    {
        return view('pages.kelola.user');
    }

    public function kelolaklien() 
    {
        return view('pages.kelola.klien');
    }

    public function kelolakaryawan() 
    {
        return view('pages.kelola.karyawan');
    }

    public function dokumen() 
    {
        return view('pages.dokumen');
    }

    public function bantuan() 
    {
        return view('pages.bantuan');
    }

    public function bukutamu() 
    {
        return view('pages.bukutamu');
    }

    public function keuanganperusahaan() 
    {
        return view('pages.keuanganperusahaan');
    }


}