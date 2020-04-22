<?php

namespace App\Http\Controllers\AdminSungai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Data_input;
use App\Model\Detail_data_input;
use App\Model\User;
use DB;
class PetaController extends Controller
{
    public function index(Request $request){
    	$data['data_input'] = Data_input::select('*','data_input.id', 'users.id as id_users','data_input.status as status')->join('users','users.id','=','data_input.user_id')->where('data_input.sungai_id',$request->user()->sungai_id)->get();
    	$data['detail'] = Detail_data_input::join('variable','variable.id','=','detail_data_input.variable_id')->get();
    	$data['dasar'] = DB::table('koordinate_sungai')
        ->select('id_kel_dasar_sub', DB::raw('count(*) as total'))
        ->groupBy('id_kel_dasar_sub')
        ->get();
        return view('admin_sungai/peta/peta',$data);
    }
    public function verif_titik($id){
        $titik = Data_input::select('*', 'users.id as id_users')->join('users','users.id','=','data_input.user_id')->where('data_input.id',$id)->first();

        return json_encode($titik);
    }
    public function setuju($id){
        if(Data_input::find($id)->update([
            'status' => 1,
        ])){
            return back()->with('success','Data sukses diterima !');

        }else{
            return back()->withErrors(['Ada kesalahan pada saat Edit.']);
        }
    }
    public function tolak($id){
        if(Data_input::find($id)->update([
            'status' => 2,
        ])){
            return back()->with('success','Data sukses ditolak !');

        }else{
            return back()->withErrors(['Ada kesalahan pada saat Edit.']);
        }
    }
}