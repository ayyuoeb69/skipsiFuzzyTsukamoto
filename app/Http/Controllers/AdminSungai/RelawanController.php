<?php

namespace App\Http\Controllers\AdminSungai;
use Illuminate\Http\Request;
use App\Model\User;
use App\Http\Controllers\Controller;
class RelawanController extends Controller
{
    public function index(Request $request){
    	$data['user'] = User::select('*', 'users.id as users_id')->join('sungai','sungai.id','=','users.sungai_id')->where('status',2)->get();
        return view('admin_sungai/relawan/relawan', $data);
    }
    public function destroy(Request $request, $id){
        if(User::find($id)->delete()){
           return  back()->with('success','Data sukses dihapus !');

        }else{
              return back()->withErrors(['Ada kesalahan pada saat Hapus.']);
        }
    }
}