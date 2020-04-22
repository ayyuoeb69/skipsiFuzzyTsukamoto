<?php

namespace App\Http\Controllers\AdminUtama;
use Illuminate\Http\Request;
use App\Model\Variable;
use App\Model\Himpunan;
use App\Model\Titik;
use App\Http\Controllers\Controller;
class VariabelController extends Controller
{
    public function index(Request $request){
    	$data['variable'] = Variable::orderBy('status','ASC')->get();
        return view('admin_utama/variable/variable', $data);
    }
    public function store(Request $request){
        $this->validate($request, [
            'nama_variable' => 'required','max:100',
            'status' => 'required'
        ]);
        if(Variable::create([
            'nama_variable' => $request->nama_variable,
            'status' => $request->status,
        ])){
            return  back()->with('success','Data sukses ditambahkan !');
        }else{
            return back()->withErrors(['Ada kesalahan pada saat Input.']);
        }
    }
    public function destroy(Request $request, $id){
    	$data['himpunan'] =  Himpunan::where('variable_id', $id)->orderBy('urutan', 'ASC')->get();
    	 $himpunan = [];
        for($i=0;$i<count($data['himpunan']);$i++){
            $himpunan[$i] = $data['himpunan'][$i]->id;
        }
        $data['titik'] = Titik::whereIn('himpunan_id', $himpunan)->delete();
         Himpunan::where('variable_id', $id)->delete();
        if(Variable::find($id)->delete()){
           return  back()->with('success','Data sukses dihapus !');

        }else{
              return back()->withErrors(['Ada kesalahan pada saat Hapus.']);
        }
    }
    public function edit(Request $request, $id){
        $this->validate($request, [
            'nama_variable' => 'required','max:100'
        ]);
        if(Variable::find($id)->update([
            'nama_variable' => $request->nama_variable,
        ])){
            return redirect()->route('admin_utama_variable')->with('success','Data sukses diedit !');

        }else{
            return back()->withErrors(['Ada kesalahan pada saat Edit.']);
        }
    }
}
