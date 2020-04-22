<?php

namespace App\Http\Controllers\Utama;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class UtamaController extends Controller
{
    public function index(Request $request){
    	$data['dasar'] = DB::table('koordinate_sungai')
        ->select('id_kel_dasar_sub', DB::raw('count(*) as total'))
        ->groupBy('id_kel_dasar_sub')
        ->get();
        return view('utama/utama',$data);
    }

}