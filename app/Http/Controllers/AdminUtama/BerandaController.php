<?php

namespace App\Http\Controllers\AdminUtama;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BerandaController extends Controller
{
    public function index(Request $request){
        return view('admin_utama/beranda/beranda');
    }

}
