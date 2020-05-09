<?php

namespace App\Http\Controllers\AdminUtama;
use Illuminate\Http\Request;
use App\Model\Himpunan;
use App\Model\Variable;
use App\Model\Titik;
use App\Http\Controllers\Controller;
class HimpunanController extends Controller
{
    public function index(Request $request, $id){
    	$data['variable'] = Variable::find($id);
        $data['himpunan'] =  Himpunan::where('variable_id', $id)->orderBy('urutan', 'ASC')->get();
        $himpunan = [];
        for($i=0;$i<count($data['himpunan']);$i++){
            $himpunan[$i] = $data['himpunan'][$i]->id;
        }
        $data['titik'] = Titik::whereIn('himpunan_id', $himpunan)->get();
        return view('admin_utama/himpunan/himpunan', $data);
    }
    public function settings(Request $request, $id){
        
        $data['variable'] = Variable::find($id);
        $data['himpunan'] = Himpunan::all();
        $data['id'] = $id;
        return view('admin_utama/himpunan/setting-himpunan', $data);
        
    }
    public function store(Request $request, $id){
        $j = 1;
        for($i = 0;$i<$request->banyak;$i++){

            $nama = trim($_REQUEST['nama_' . $j]);
            $banyak = trim($_REQUEST['banyak_' . $j]);
            
            $kode = 'kode'.rand().$banyak.date("his");
            if($banyak == 2){
                if(trim($_REQUEST['banyak' . $j.'y0'] )< trim($_REQUEST['banyak' . $j.'y1'])){
                    $fungsi = 'naik';
                }else{
                    $fungsi = 'turun';
                }
            }else if($banyak == 3){
                $fungsi = 'segitiga';
            }else if($banyak == 4){
                $fungsi = 'trapesium';
            }
            Himpunan::create([
             'unique_code' => $kode,
             'nama_himpunan' => $nama,
             'jumlah_titik' => $banyak,
             'variable_id' => $id,
             'fungsi' => $fungsi,
             'urutan' => $j
            ]);
            
            $himpunan = Himpunan::where('unique_code', $kode)->first();
            $no = 1;
            for($k = 0; $k < $banyak; $k++){
                $titikx = trim($_REQUEST['banyak'.$j.'x'.$k]);
                $titiky = trim($_REQUEST['banyak'.$j.'y'.$k]);
                Titik::create([
                    'titikx' => $titikx,
                    'titiky' => $titiky,
                    'urutan' => $no,
                    'himpunan_id' => $himpunan->id
                ]);
                $no++;
            }
            $j++;
        }
        return redirect()->route('admin_utama_variable')->with('success','Data sukses ditambahkan !');

    }
    public function destroy(Request $request, $id){

        if(Himpunan::find($id)->delete()){
           return  back()->with('success','Data sukses dihapus !');

        }else{
              return back()->withErrors(['Ada kesalahan pada saat Input.']);
        }
    }
    public function edit(Request $request, $id){
        $this->validate($request, [
            'nama_himpunan' => 'required','max:100'
        ]);
        if(Himpunan::find($id)->update([
            'nama_himpunan' => $request->nama_himpunan,
        ])){
            return redirect()->route('admin_utama_himpunan')->with('success','Data sukses diedit !');

        }else{
            return back()->withErrors(['Ada kesalahan pada saat Edit.']);
        }
    }
}
