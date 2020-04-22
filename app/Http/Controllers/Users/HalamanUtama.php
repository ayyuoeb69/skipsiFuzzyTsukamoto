<?php

namespace App\Http\Controllers\Users;
use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Controllers\Controller;
class HalamanUtama extends Controller
{
    public function index(Request $request){
        return view('users/halaman_utama/index');
    }

}
