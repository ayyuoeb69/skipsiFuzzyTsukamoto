<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail_data_input extends Model
{
    protected $table = 'detail_data_input';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'data_input_id','variable_id','inputan'
    ];
}
