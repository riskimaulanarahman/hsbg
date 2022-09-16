<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelengkapanDokumen extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'kelengkapan_dokumen_klien';

}
