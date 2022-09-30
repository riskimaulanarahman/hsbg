<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayatpembayaran extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'riwayat_pembayaran';

    public function uraianbayar()
    {
        return $this->belongsTo('App\Model\Uraianbayar','id_ref_uraian_bayar','id');
    }

}
