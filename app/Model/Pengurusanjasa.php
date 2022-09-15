<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurusanjasa extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'ref_pengurusan_jasa';

}
