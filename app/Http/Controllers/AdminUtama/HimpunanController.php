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
        // if($request->nama != null){
        //     if($request->banyaka != 0){
        //         $banyaka = $request->banyaka;
        //         if($banyaka == 2){
        //             if($request->banyak1y0 < $request->banyak1y1){
        //                 $fungsi = 'naik';
        //             }else{
        //                 $fungsi = 'turun';
        //             }
        //         }else if($banyaka == 3){
        //             $fungsi = 'segitiga';
        //         }else if($banyaka == 4){
        //             $fungsi = 'trapesium';
        //         }
        //     }else{
        //         $banyaka = 0;
        //         $fungsi = 0;
        //     }
        //     $kodea = 'kodea'.rand().date("his");
        //     $data = [
        //         'himpunan' => $request->temp_nama1,
        //         'id_var' => $request->id,
        //         'jmlh_titik' => $banyaka,
        //         'fungsi' => $fungsi,
        //         'urutan' => 1,
        //         'kode_unik' => $kodea
        //     ];
        //     $query = $this->db->insert('tbl_himpunan', $data);
        //     $j = 1;
        //     for($i = 0; $i<$banyaka; $i++){
        //         $datas = [
        //             'titikx' => $request->banyak1x.$i,
        //             'titiky' => $request->banyak1y.$i,
        //             'id_himpunan' => $kodea,
        //             'urutan' => $j
        //         ];
        //         $this->db->insert('tbl_titik', $datas);
        //         $j++;
        //     }
        //     // die($data);
        // }
        // if($request->temp_nama2 != null){
        //     if($request->banyakb != 0){
        //         $banyakb = $request->banyakb;
        //         if($banyakb == 2){
        //             if($request->banyak2y0 < $request->banyak2y1){
        //                 $fungsi = 'naik';
        //             }else{
        //                 $fungsi = 'turun';
        //             }
        //         }else if($banyakb == 3){
        //             $fungsi = 'segitiga';
        //         }else if($banyakb == 4){
        //             $fungsi = 'trapesium';
        //         }
        //     }else{
        //         $banyakb = 0;
        //         $fungsi = 0;
        //     }
        //     $kodeb = 'kodeb'.rand().date("his");
        //     $data = [
        //         'himpunan' => $request->post('temp_nama2'),
        //         'id_var' => $request->id,
        //         'jmlh_titik' => $banyakb,
        //         'fungsi' => $fungsi,
        //         'urutan' => 2,
        //         'kode_unik' => $kodeb
        //     ];
        //     $query = $this->db->insert('tbl_himpunan', $data);
        //     $j = 1;
        //     for($i = 0; $i<$banyakb; $i++){
        //         $datas = [
        //             'titikx' => $request->banyak2x.$i,
        //             'titiky' => $request->banyak2y.$i,
        //             'id_himpunan' => $kodeb,
        //             'urutan' => $j
        //         ];
        //         $this->db->insert('tbl_titik', $datas);
        //         $j++;
        //     }
        //     // die($data);
        // }
        // if($request->temp_nama3!= null){
        //     if($request->banyakc != 0){
        //         $banyakc = $request->banyakc;
        //         if($banyakc == 2){
        //             if($request->banyak3y0 < $request->banyak3y1){
        //                 $fungsi = 'naik';
        //             }else{
        //                 $fungsi = 'turun';
        //             }
        //         }else if($banyakc == 3){
        //             $fungsi = 'segitiga';
        //         }else if($banyakc == 4){
        //             $fungsi = 'trapesium';
        //         }
        //     }else{
        //         $banyakc = 0;
        //         $fungsi = 0;
        //     }
        //     $kodec = 'kodec'.rand().date("his");
        //     $data = [
        //         'himpunan' => $request->temp_nama3,
        //         'id_var' => $request->id,
        //         'jmlh_titik' => $banyakc,
        //         'fungsi' => $fungsi,
        //         'urutan' => 3,
        //         'kode_unik' => $kodec
        //     ];
        //     $query = $this->db->insert('tbl_himpunan', $data);
        //     $j = 1;
        //     for($i = 0; $i<$banyakc; $i++){
        //         $datas = [
        //             'titikx' => $request->banyak3x.$i,
        //             'titiky' => $request->banyak3y.$i,
        //             'id_himpunan' => $kodec,
        //             'urutan' => $j
        //         ];
        //         $this->db->insert('tbl_titik', $datas);
        //         $j++;
        //     }
        //     // die($data);
        // }
        // if($request->temp_nama4!= null){
        //     if($request->banyakd != 0){
        //         $banyakd = $request->banyakd;
        //         if($banyakd == 2){
        //             if($request->banyak4y0 < $request->banyak4y1){
        //                 $fungsi = 'naik';
        //             }else{
        //                 $fungsi = 'turun';
        //             }
        //         }else if($banyakd == 3){
        //             $fungsi = 'segitiga';
        //         }else if($banyakd == 4){
        //             $fungsi = 'trapesium';
        //         }
        //     }else{
        //         $banyakd = 0;
        //         $fungsi = 0;
        //     }
        //     $koded = 'koded'.rand().date("his");
        //     $data = [
        //         'himpunan' => $request->temp_nama4,
        //         'id_var' => $request->id,
        //         'jmlh_titik' => $banyakd,
        //         'fungsi' => $fungsi,
        //         'urutan' => 4,
        //         'kode_unik' => $koded
        //     ];
        //     $query = $this->db->insert('tbl_himpunan', $data);
        //     $j = 1;
        //     for($i = 0; $i<$banyakd; $i++){
        //         $datas = [
        //             'titikx' => $request->banyak4x.$i,
        //             'titiky' => $request->banyak4y.$i,
        //             'id_himpunan' => $koded,
        //             'urutan' => $j
        //         ];
        //         $this->db->insert('tbl_titik', $datas);
        //         $j++;
        //     }
        //     // die($data);
        // }
    }
    // public function store(Request $request){
    //     $this->validate($request, [
    //         'nama_himpunan' => 'required','max:100'
    //     ]);
    //     if(Himpunan::create([
    //         'nama_himpunan' => $request->nama_himpunan,
    //     ])){
    //         return  back()->with('success','Data sukses ditambahkan !');
    //     }else{
    //         return back()->withErrors(['Ada kesalahan pada saat Input.']);
    //     }
    // }
    public function destroy(Request $request, $id){

        if(Himpunan::find($id)->delete()){
           return  back()->with('success','Data sukses ditambahkan !');

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
