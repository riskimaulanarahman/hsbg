<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayatpembayaran extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'riwayat_pembayaran';

}
