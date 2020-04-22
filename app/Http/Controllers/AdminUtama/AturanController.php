<?php

namespace App\Http\Controllers\AdminUtama;
use Illuminate\Http\Request;
use App\Model\Aturan;
use App\Model\Variable;
use App\Model\Himpunan;
use App\Model\Detail_aturan;
use App\Http\Controllers\Controller;
class AturanController extends Controller
{

    public function index(Request $request){
        // $this->auto_input();
        $data['aturan'] =  Aturan::get();
        $data['detail'] =  Detail_aturan::select('*','detail_aturan.id as detail_aturan_id')->join('himpunan', 'himpunan.id','=','detail_aturan.himpunan_id')->join('variable', 'variable.id','=','himpunan.variable_id')->get();
        
        return view('admin_utama/aturan/aturan', $data);
    }
    public function add(Request $request){
        $data['variable_input'] = Variable::where('status',0)->orderBy('status','ASC')->get();
        $data['variable_output'] = Variable::where('status',1)->orderBy('status','ASC')->get();
        $data['himpunan'] = Himpunan::orderBy('variable_id','ASC')->orderBy('created_at','ASC')->get();
        return view('admin_utama/aturan/add_aturan', $data);
    }
    public function store(Request $request){
       $aturan_all = Aturan::all();
       $count = count($aturan_all) + 1;
       $nama_aturan = "Aturan ".$count;
       $input_aturan = Aturan::create([
        'nama_aturan' => $nama_aturan,
        ]);
           if($input_aturan == true){
                for($i=0;$i<count($request->himpunan_input);$i++){
                    Detail_aturan::create([
                        'himpunan_id' => $request->himpunan_input[$i],
                        'aturan_id'=>$input_aturan->id
                    ]);
                }
                Detail_aturan::create([
                    'himpunan_id' => $request->himpunan_output,
                    'aturan_id'=>$input_aturan->id
                ]);
                return  back()->with('success','Data sukses ditambahkan !');
        }else{
            return back()->withErrors(['Ada kesalahan pada saat Input.']);
        }
    }
    public function destroy(Request $request, $id){
       
        Detail_aturan::where('aturan_id', $id)->delete();
        if(Aturan::find($id)->delete()){
            return  back()->with('success','Data sukses dihapus !');

        }else{
            return back()->withErrors(['Ada kesalahan pada saat Hapus.']);
        }
    }
    public function auto_input(){
        $aturan_all = Aturan::all();
       $count = count($aturan_all) + 1;
       $nama_aturan = "Aturan ".$count;

        for($i=4;$i>0;$i--){
            for($j=4;$j>0;$j--){
                for($k=4;$k>0;$k--){
                    for($l=4;$l>0;$l--){
                        $total = ($i+$j+$k+$l)/4;
                        if($total >= 1 && $total<=1.7){
                            $hasil = 17;
                        }else if($total >= 1.8 && $total<=2.5){
                            $hasil = 18;
                        }else if($total >= 2.6 && $total<=3.2){
                            $hasil = 19;
                        }else if($total >= 3.3 && $total<=4){
                            $hasil = 20;
                        }
                        if($i == 4){
                            $famili = 4;
                        }else if($i == 3){
                            $famili = 3;
                        }else if($i == 2){
                            $famili = 2;
                        }else if($i == 1){
                            $famili = 1;
                        }

                        if($j == 4){
                            $ept = 8;
                        }else if($j == 3){
                            $ept = 7;
                        }else if($j == 2){
                            $ept = 6;
                        }else if($j == 1){
                            $ept = 5;
                        }

                        if($k == 4){
                            $persen = 12;
                        }else if($k == 3){
                            $persen = 11;
                        }else if($k == 2){
                            $persen = 10;
                        }else if($k == 1){
                            $persen = 9;
                        }

                        if($l == 4){
                            $indeks = 16;
                        }else if($l == 3){
                            $indeks = 15;
                        }else if($l == 2){
                            $indeks = 14;
                        }else if($l == 1){
                            $indeks = 13;
                        }

                        $input_aturan = Aturan::create([
                        'nama_aturan' => $nama_aturan,
                        ]);
                        Detail_aturan::create([
                        'himpunan_id' => $famili,
                        'aturan_id'=>$input_aturan->id
                        ]);
                        Detail_aturan::create([
                        'himpunan_id' => $ept,
                        'aturan_id'=>$input_aturan->id
                        ]);
                        Detail_aturan::create([
                        'himpunan_id' => $persen,
                        'aturan_id'=>$input_aturan->id
                        ]);
                        Detail_aturan::create([
                        'himpunan_id' => $indeks,
                        'aturan_id'=>$input_aturan->id
                        ]);
                        Detail_aturan::create([
                        'himpunan_id' => $hasil,
                        'aturan_id'=>$input_aturan->id
                        ]);
                        
                        $count++;
                        $nama_aturan = "Aturan ".$count;
                    }
                }
            }
        }
    }
}
