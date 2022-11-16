<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenistransaksiperusahaan extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'ref_jenis_transaksi_perusahaan';

}
