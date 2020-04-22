<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Data_input extends Model
{
    protected $table = 'data_input';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id','sungai_id','latitude','longitude','status','hasil'
    ];
}
