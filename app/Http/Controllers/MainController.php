<?php
namespace App\Http\Controllers;


class MainController extends Controller 
{

    public function refdokumenklien() 
    {
        return view('pages.referensi.dokumenklien');
    }

    public function refjenisbiayaperusahaan() 
    {
        return view('pages.referensi.jenisbiayaperusahaan');
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


}