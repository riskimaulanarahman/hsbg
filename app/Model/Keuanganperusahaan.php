<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuanganperusahaan extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'transaksi_keuangan';

}
