<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmModel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'umkm';
    public $timestamps = false;
}
