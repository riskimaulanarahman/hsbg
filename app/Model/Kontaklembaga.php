<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontaklembaga extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'kontak_lembaga';

}
