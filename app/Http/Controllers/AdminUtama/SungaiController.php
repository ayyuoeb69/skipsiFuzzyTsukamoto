<?php

namespace App\Http\Controllers\AdminUtama;
use Illuminate\Http\Request;
use App\Model\Sungai;
use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
class SungaiController extends Controller
{
    public function index(){
    	$data['sungai'] = Sungai::all();
        $data['user'] = User::select('*', 'users.id as users_id')->join('sungai','sungai.id','=','users.sungai_id')->where('status',1)->get();
        return view('admin_utama/sungai/sungai', $data);
    }
    public function store(Request $request){
        $this->validate($request, [
            'sungai' => 'required'
        ]);
        if(Sungai::create([
            'sungai' => $request->sungai,
        ])){
            return  back()->with('success','Data sukses ditambahkan !');
        }else{
            return back()->withErrors(['Ada kesalahan pada saat Input.']);
        }
    }
    public function store_admin(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'sungai' => 'required',
        ]);
        if(User::create([
            'sungai_id' => $request->sungai,
            'username' => $request->username,
            'hp' => $request->hp,
            'status' => 1,
            'password' => Hash::make($request->password),
        ])){
            return  back()->with('success','Data sukses ditambahkan !');
        }else{
            return back()->withErrors(['Ada kesalahan pada saat Input.']);
        }
    }
    public function destroy(Request $request, $id){
        if(Sungai::find($id)->delete()){
           return  back()->with('success','Data sukses dihapus !');

        }else{
              return back()->withErrors(['Ada kesalahan pada saat Hapus.']);
        }
    }
    public function destroy_admin(Request $request, $id){
        if(User::find($id)->delete()){
           return  back()->with('success','Data sukses dihapus !');

        }else{
              return back()->withErrors(['Ada kesalahan pada saat Hapus.']);
        }
    }
    public function edit(Request $request, $id){
        if(Sungai::find($id)->update([
            'sungai' => $request->sungai,
        ])){
            return redirect()->route('admin_utama_sungai')->with('success','Data sukses diedit !');

        }else{
            return back()->withErrors(['Ada kesalahan pada saat Edit.']);
        }
    }
}
