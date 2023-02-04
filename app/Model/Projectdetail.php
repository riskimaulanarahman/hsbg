<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectdetail extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'projectdetails';

}
