<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefMitra extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'refmitra';

}
