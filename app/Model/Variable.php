<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $table = 'variable';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'nama_variable', 'status'
    ];
}
