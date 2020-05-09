<?php

namespace App\Http\Controllers\Utama;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Data_input;
use App\Model\Detail_data_input;
class UtamaController extends Controller
{
    public function index(Request $request){
    	$data['dasar'] = DB::table('koordinate_sungai')
        ->select('id_kel_dasar_sub', DB::raw('count(*) as total'))
        ->groupBy('id_kel_dasar_sub')
        ->get();
        
        return view('utama/utama',$data);
    }
    public function titik(){
    	$titik = Data_input::select('*', 'users.id as id_users','data_input.status as status','data_input.created_at as tanggal')->join('users','users.id','=','data_input.user_id')->where('data_input.status',1)->get();
    	return json_encode($titik);
    }
    public function detail_titik($id){
    	$titik = Detail_data_input::join('variable','variable.id','=','detail_data_input.variable_id')->where('data_input_id', $id)->get();
    	return json_encode($titik);
    }
    public function filter(Request $request){
    	$titik = Data_input::select('*', 'users.id as id_users','data_input.status as status','data_input.created_at as tanggal')->join('users','users.id','=','data_input.user_id')->where('data_input.status',1)->whereDate('data_input.created_at',$request->tanggal)->get();
    	return json_encode($titik);
    }
}