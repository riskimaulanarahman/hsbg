<?php
namespace App\Http\Controllers;

use App\Model\Masterssh;
use DB;
use Illuminate\Http\Request;

class MainController extends Controller 
{

    public function masterssh() 
    {
        return view('pages.masterssh');
    }

    public function listmasterssh()
    {
        return Masterssh::all();
    }

    public function getmasterssh($id) 
    {
        return Masterssh::find($id);
    }

    public function simulasi() 
    {
        return view('pages.simulasi');
    }

    public function kelolauser() 
    {
        return view('pages.kelola.user');
    }


}