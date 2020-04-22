<?php

namespace App\Http\Controllers\AdminSungai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class BerandaController extends Controller
{
    public function index(Request $request){
        return view('admin_sungai/beranda/beranda');
    }

}
