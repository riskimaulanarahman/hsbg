<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use Illuminate\Support\Carbon;

use App\Model\RefMitra;
use App\Model\RefStatus;
use App\Model\Project;

class ListController extends Controller
{

    public function listMitra() 
    {
        return RefMitra::select('id', 'nama_mitra')->get();
    }

    public function listsubStatus() 
    {
        return RefStatus::select('id', 'substatus')->get();
    }

    public function totalSP() 
    {
        return Project::selectRaw('sp')->count();
    }

    public function totalSPchart() 
    {
        $data = Project::selectRaw('sp,round(avg(progress),1) as jml')->groupBy('sp')->get();
        return json_encode($data,JSON_NUMERIC_CHECK);
    }


}
