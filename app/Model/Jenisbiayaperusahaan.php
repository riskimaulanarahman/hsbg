<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenisbiayaperusahaan extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'ref_jenis_biaya_perusahaan';

}
