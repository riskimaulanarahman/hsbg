<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftarpengurusan extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'daftar_pengurusan';

    public function createdby()
    {
        return $this->belongsTo('App\User','createdby','id');
    }

    public function klien()
    {
        return $this->belongsTo('App\Model\Klien','id_klien','id');
    }

    public function pengurusanjasa()
    {
        return $this->belongsTo('App\Model\Pengurusanjasa','id_ref_pengurusan_jasa','id');
    }

}
