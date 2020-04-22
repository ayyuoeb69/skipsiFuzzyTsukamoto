<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dasar extends Model
{
    protected $table = 'koordinate_sungai';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'lat_koor_dasar','lng_koor_dasar','sungai_id','id_kel_dasar_sub'
    ];
}
