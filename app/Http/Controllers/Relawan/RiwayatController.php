<?php

namespace App\Http\Controllers\Relawan;
use Illuminate\Http\Request;
use App\Model\Data_input;
use App\Model\Detail_data_input;
use App\Http\Controllers\Controller;
class RiwayatController extends Controller
{
    public function index(Request $request){
    	$data['data_input'] = Data_input::where('user_id',$request->user()->id)->get();
    	$data['detail'] = Detail_data_input::join('variable','variable.id','=','detail_data_input.variable_id')->get();
        return view('relawan/riwayat/riwayat',$data);
    }
    public function destroy(Request $request, $id){
    	 Detail_data_input::where('data_input_id', $id)->delete();
        if(Data_input::find($id)->delete()){
            return  back()->with('success','Data sukses dihapus !');

        }else{
            return back()->withErrors(['Ada kesalahan pada saat Hapus.']);
        }
    }
}