<?php

namespace App\Http\Controllers\Relawan;
use Illuminate\Http\Request;
use App\Model\Variable;
use App\Model\Dasar;
use App\Model\Titik;
use App\Model\Aturan;
use App\Model\Detail_aturan;
use App\Model\Data_input;
use App\Model\Detail_data_input;
use App\Http\Controllers\Controller;
use DB;
class InputController extends Controller
{
    public function index(Request $request){
    	$data['variable'] = Variable::where('status',0)->get();
        $data['dasar'] = DB::table('koordinate_sungai')
        ->select('id_kel_dasar_sub', DB::raw('count(*) as total'))
        ->groupBy('id_kel_dasar_sub')
        ->get();
        return view('relawan/input/input', $data);
    }
    public function dasar_sungai($id){
        $dasar = Dasar::where('id_kel_dasar_sub',$id)->get();

        return json_encode($dasar);
    }
    public function store(Request $request){
       
        if($request->titik_lat != null && $request->titik_lng != null){
            $lat = $request->titik_lat;
            $lng = $request->titik_lng;
        }else{
            $lat = $request->titik_lat_value;
            $lng = $request->titik_lng_value;
        }
        $input_baru = Data_input::create([
            'user_id' => $request->user()->id,
            'sungai_id' => $request->user()->sungai_id,
            'latitude' => $lat,
            'longitude' => $lng,
            'status'=>0
        ]);
        if($input_baru == true){
            $aturan = Aturan::all();
            $variable = Variable::where('status',0)->get();
            $i = 0;
            foreach($variable as $item){
                Detail_data_input::create([
                    'data_input_id' => $input_baru->id,
                    'variable_id'=> $item->id,
                    'inputan'=> $request->nama_variable[$i]
                ]);
                $i++;
            }
            $i = 0;
            foreach ($aturan as $item_aturan) {
                $detail_aturan = Detail_aturan::select('*','himpunan.id as id_himpunan','variable.id as id_variable')->join('himpunan','himpunan.id','=','detail_aturan.himpunan_id')->join('variable','variable.id','=','himpunan.variable_id')->where('detail_aturan.aturan_id',$item_aturan->id)->orderBy('detail_aturan.id','ASC')->get();
                
                $temp = 0;
                $a = 0;
                foreach ($detail_aturan as $item_detail) {
                    if($item_detail->status == 0){

                        $detail_data_input = Detail_data_input::where('data_input_id',$input_baru->id)->where('variable_id',$item_detail->variable_id)->first();
                        $inputan = $detail_data_input->inputan;
                        $titik = Titik::where('himpunan_id',$item_detail->id_himpunan)->orderBy('urutan','ASC')->get();

                        if($item_detail->fungsi == 'trapesium'){
                            if($inputan>$titik[0]->titikx && $inputan<$titik[1]->titikx){
                                $hasil_temp = ($inputan-$titik[0]->titikx) / ($titik[1]->titikx-$titik[0]->titikx);
                            }else if($inputan>=$titik[1]->titikx && $inputan<=$titik[2]->titikx){
                                $hasil_temp = 1;
                            }else if($inputan>$titik[2]->titikx && $inputan<$titik[3]->titikx){
                                $hasil_temp = ($titik[3]->titikx-$inputan) / ($titik[3]->titikx-$titik[2]->titikx);
                            }else if($inputan<=$titik[0]->titikx || $inputan>=$titik[3]->titikx){
                                $hasil_temp = 0;
                            }
                        }else if($item_detail->fungsi == 'segitiga'){
                            if($inputan>$titik[0]->titikx && $inputan<$titik[1]->titikx){
                                $hasil_temp = ($inputan-$titik[0]->titikx) / ($titik[1]->titikx-$titik[0]->titikx);
                            }else if($inputan>$titik[1]->titikx && $inputan<$titik[2]->titikx){
                                $hasil_temp = ($titik[2]->titikx-$inputan) / ($titik[2]->titikx-$titik[1]->titikx);
                            }else if($inputan==$titik[1]->titikx){
                                $hasil_temp = 1;
                            }else if($inputan<=$titik[0]->titikx || $inputan>=$titik[2]->titikx){
                                $hasil_temp = 0;
                            }
                        }else if($item_detail->fungsi == 'turun'){
                            if($inputan>=$titik[0]->titikx && $inputan<$titik[1]->titikx){
                                $hasil_temp = ($titik[1]->titikx-$inputan) / ($titik[1]->titikx-$titik[0]->titikx);
                            }else if($inputan>=$titik[1]->titikx){
                                $hasil_temp = 0;    
                            }else if($inputan<$titik[0]->titikx){
                                $hasil_temp = 1;    
                            }
                        }else if($item_detail->fungsi == 'naik'){
                            if($inputan>$titik[0]->titikx && $inputan<=$titik[1]->titikx){
                                $hasil_temp = ($inputan-$titik[0]->titikx) / ($titik[1]->titikx-$titik[0]->titikx);
                            }else if($inputan>$titik[1]->titikx){
                                $hasil_temp = 1;    
                            }else if($inputan<=$titik[0]->titikx){
                                $hasil_temp = 0;    
                            }
                        }
                        if($i==86){
                            $b[$a] = $hasil_temp;
                            $a++;
                        }
                        if($temp == 0){
                            $min = $hasil_temp;
                            $temp = 1;
                        }
                        if($hasil_temp < $min){
                            $min = $hasil_temp;
                        }
                    }else{
                        //naik
                        $nilai_aturan_1 = ($min * ($titik[1]->titikx-$titik[0]->titikx)) + $titik[0]->titikx;
                        //turun
                        $nilai_aturan_2 = $titik[2]->titikx - ( $min * ($titik[2]->titikx-$titik[1]->titikx));
                        if($nilai_aturan_1<=$nilai_aturan_2){
                            $hasil_aturan = $nilai_aturan_1;
                        }else{
                            $hasil_aturan = $nilai_aturan_2;
                        }
                    }
                }
                $semua_nilai_aturan[$i] = $hasil_aturan;
                $semua_min[$i] = $min;
                $i++;
            }
            $atas = 0;
            for($i=0;$i<count($semua_nilai_aturan);$i++){
                $temm[$i] = ($semua_nilai_aturan[$i] * $semua_min[$i]) + $atas;
                $atas = ($semua_nilai_aturan[$i] * $semua_min[$i]) + $atas;
            }
            $bawah = 0;
            for($i=0;$i<count($semua_min);$i++){
                $bawah = $semua_min[$i] + $bawah;
            }
            $defuzzy = $atas / $bawah;
            Data_input::find($input_baru->id)->update([
                'hasil' => $defuzzy
            ]);
            
            return  redirect()->route('relawan_riwayat')->with('success','Data sukses ditambahkan !');
        }else{
            return back()->withErrors(['Ada kesalahan pada saat Input.']);
        }
    }
}