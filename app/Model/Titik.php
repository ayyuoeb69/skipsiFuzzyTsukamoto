<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Titik extends Model
{
    protected $table = 'titik';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'titikx','titiky','himpunan_id','urutan'
    ];
}
