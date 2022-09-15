<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uraianbayar extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'ref_uraian_bayar';

}
