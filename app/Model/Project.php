<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'project'; 

    // public function createdby()
    // { ii
    //     return $this->belongsTo('App\User','createdby','id');
    // }

    // public function klien()
    // {
    //     return $this->belongsTo('App\Model\Klien','id_klien','id');
    // }

    // public function pengurusanjasa()
    // {
    //     return $this->belongsTo('App\Model\Pengurusanjasa','id_ref_pengurusan_jasa','id');
    // }

    // public function riwayatpembayaran()
    // {
    //     return $this->hasMany('App\Model\Riwayatpembayaran','id_daftar_pengurusan')->where('deleted_status', 0);

    // }

}
