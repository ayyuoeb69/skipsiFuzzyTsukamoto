<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail_aturan extends Model
{
    protected $table = 'detail_aturan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'aturan_id','himpunan_id'
    ];
}
