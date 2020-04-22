<?php

namespace App\Http\Controllers\Relawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BerandaController extends Controller
{
    public function index(Request $request){
        return view('relawan/beranda/beranda');
    }

}
