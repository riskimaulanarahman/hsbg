<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Carbon;

use App\Model\RefMitra;
use App\Model\RefStatus;

class ListController extends Controller
{

    public function listMitra() {
        return RefMitra::select('id','nama_mitra')->get();
    }

    public function listsubStatus() {
        return RefStatus::select('id','substatus')->get();
    }


}
