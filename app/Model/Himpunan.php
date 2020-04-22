<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Himpunan extends Model
{
    protected $table = 'himpunan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'nama_himpunan', 'unique_code', 'fungsi','variable_id','jumlah_titik','urutan'
    ];
}
