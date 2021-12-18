<?php

namespace App\Http\Controllers;

use Auth;
use App\Pegawai;
use App\NotaDinas;
use App\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotaDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $listnotdin = NotaDinas::all();
        // return view ('notadinas', compact('listnotdin'));
        $nota = NotaDinas::all();

        return view ('notdin.arsip', compact('nota'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        return view ('notdin.buatnotdin', compact('listJabatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nomor' => 'string|max:50|unique:notadinas|nullable',
            'kepada' => 'required|array|max:255',
            'dari' => 'required|string|max:255',
            'tembusan' => 'string|nullable',
            'tanggal' => 'required|date',
            'sifat' => 'required|string',
            'lampiran' => 'mimes:pdf|nullable',
            'hal' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
            'koreksi' => 'string|max:255|nullable',
        ]);

        //KEPADA
        // menyatukan/implode semua "kepada" menjadi satu string
        if(isset($request->kepada) && is_array($request->kepada)){
            $allkepada = collect($request->kepada)->implode(',');
            $request->merge(['kepada' => $allkepada]);
        }

        //STATUS
        //READ
        //PENERIMA
        //jika yang membuat jabatannya sesuai "dari"
        if( (Auth::user()->id_jabatan) == ($request->dari) ){
            $allpenerima =  $request->kepada.','.$request->tembusan;
            $request->merge(['id_penerima' => $allpenerima]);
            $request->merge(['status' => '3']);

            //menghitung jumlah penerima
            $penerima = explode(',',$allpenerima);
            $sumpenerima = count($penerima);
            //input value array read sesuai dengan jumlah penerima
            $read;
            for($i = 0; $i < $sumpenerima; $i++){
                $read[$i] = '1';
            }

            $allread = collect($read)->implode(',');
            $request->merge(['read' => $allread]);
        }else{
        // jika yang membuat nota dinas adalah staff
            $intDari = (integer)$request->dari;
            $cariId = Pegawai::where([ 'id_jabatan' => $intDari])->first();

            $request->merge(['read' => '1']);
            $request->merge(['id_penerima' => $cariId->id]);
            $request->merge(['status' => '1']);
        }

        //LAMPIRAN
        // memroses file lampiran
        if($request->hasFile('lampiran')){
           
            $fileRename = 'notadinas-'. $request->hal . '.' . $request->file('lampiran')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('notadinas\lampiran', $request->lampiran, $fileRename);
            $lampiranDB = '/notadinas/lampiran/'.$fileRename;
            $request->merge(['lampiran' => $lampiranDB]);
            
        }

        //SOFTFILE
        // memroses file softfile
        if($temp = $request->hasFile('softfile')){
            //dipindahin via temp
            $temp = $request->file('softfile');
            $fileName = 'notadinas-'. $request->hal . '.' . $request->file('softfile')->getClientOriginalExtension();
            //$temp->move($direktori, $fileName);
            Storage::disk('public')->putFileAs('notadinas\softfile', $temp, $fileName);
            $fileDB = '/notadinas/softfile/'.$fileName;
            $request->merge(['softfile' => $fileDB]);
            //mantapp bisa 27/07/20
        }

        $storenotdin = NotaDinas::create($request->input());
        return redirect()->route('notadinas.sent', Auth::user()->id)->with('success', 'Nota Dinas berhasil dibuat.');
    }

    //convert id jabatan ke nama jabatan
    public static function disJabatan($id){
        //memisahkan yang ada komanya(explode)
        $jabatan = explode(',',$id);
        //menghitung jumlahnya
        $sumjabatan = count($jabatan);
        //mencari namajabatan di tabel jabatan
        for($i = 0; $i < $sumjabatan; $i++){
                $intJabatan[$i] = (integer)$jabatan[$i];
                $disJabatan[$i] = Jabatan::where([ 'id' => $intJabatan[$i]])->value('jabatan');
        }
        //menyatukan dengan koma (implode)
        $alljabatan = collect($disJabatan)->implode(',');

        return $alljabatan;
    }

    public function sent($id)
    {
        $nota = NotaDinas::where([ 'id_pembuat' => $id])->get();

        return view ('notdin.terkirim', compact('nota'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    // public function show($id)
    // // {
    //     $nota = NotaDinas::where([ 'id' => $id])->first();
    //     return view('shownotdin', compact('nota'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notdin = NotaDinas::where(['id' => $id])->get();
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        return view ('notdin.update', compact('notdin', 'listJabatan'));
    }

    // public function edit(NotaDinas $notdin)
    // {
    //     return view('editnota', compact('notdin'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //YOK HARI INI NOTDIN BERESSSSSS TRUS LANJUT LIAT ALUR YG LAEN SURMAS/DISPOSISI/SURKEL 27/07/20
    
    public function update(Request $request, $id)
    {   
        //to check error
        $this->validate($request, [
            'nomor' => 'string|max:50|nullable|unique:notadinas,' . 'id',
            'kepada' => 'required|array|max:255',
            'dari' => 'required|string|max:255',
            'tembusan' => 'string|nullable',
            'tanggal' => 'required|date',
            'sifat' => 'required|string',
            'lampiran' => 'mimes:pdf|nullable',
            'hal' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
            'koreksi' => 'string|max:255|nullable',
        ]);

        //inisiasi notadinas
        //mengambil notdin yang akan diupdate dari database
        $updatenotdin = \App\NotaDinas::find($id);

        //nomor
        $updatenotdin->nomor = $request->nomor;

        //kepada
        // menyatukan/implode semua kepada menjadi satu string
        if(isset($request->kepada) && is_array($request->kepada)){
            $allkepada = collect($request->kepada)->implode(',');
            $request->merge(['kepada' => $allkepada]);
            //merubah kepada dengan yg request->kepada
            $updatenotdin->kepada = $request->kepada; 
        }

        //dari
        $updatenotdin->dari = $request->dari;
        //tembusan
        $updatenotdin->tembusan = $request->tembusan;
        //tanggal
        $updatenotdin->tanggal = $request->tanggal;
        //sifat
        $updatenotdin->sifat = $request->sifat;
        //hal atau perihal
        $updatenotdin->hal = $request->hal;

        //lampiran
        //nama filee bisa ditambah dariiiiiiiii sama tanggal???????????????????????????????
        // tetep diproses walau ada perubahan/tidak pada perihal, tetep di rename
        // kondisinya tetep perubahan di file atau engga
        if($request->hasFile('lampiran')){
            //hapus lampiran yang lama jika ada
            if(isset($updatenotdin->lampiran)){
                Storage::disk('public')->delete($updatenotdin->lampiran);
            }

            $fileRename = 'notadinas-'. $request->hal . '.' . $request->file('lampiran')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('notadinas\lampiran', $request->lampiran, $fileRename);
            $lampiranDB = '/notadinas/lampiran/'.$fileRename;
            $updatenotdin->lampiran = $lampiranDB;
        }else{
            //Sukses RUN kecuali sblumnya NULL------------------------------------------------------------- 

            //jika terjadi perubahan terhadap perihal
            //rename id aja, gausah pake perihal yoi?gabsa karena belom dicreate
            if(isset($updatenotdin->lampiran)){
                $fileRename = 'notadinas-'. $request->hal . '.pdf';
                //di explode (pisahin) dari tanda /  , array terakhir diganti sama perihal baru.pdf
                $pisah = explode('/',$updatenotdin->lampiran);
                $nPisah = count($pisah);
                $pisah[$nPisah-1] = $fileRename;
                //reunite
                $dirfile = collect($pisah)->implode('/');
                //masukkin db > trus rename files
                
                //jika perihal tidak berubah
                if(Storage::disk('public')->exists($dirfile)){
                    $updatenotdin->lampiran = $dirfile;
                }else{
                    //Storage::move('old/file.jpg', 'new/file.jpg');
                    Storage::disk('public')->move($updatenotdin->lampiran, $dirfile);
                    $updatenotdin->lampiran = $dirfile;
                }
                 
                
            }else{
                //tetep null
                $updatenotdin->lampiran = $updatenotdin->lampiran;
            }
            
        }        

        //softfile
        if($request->hasFile('softfile')){
            //hapus softfile  yang lama jika ada
            if(isset($updatenotdin->softfile)){
                Storage::disk('public')->delete($updatenotdin->softfile);
            }

            $fileRename = 'notadinas-'. $request->hal . '.' . $request->file('softfile')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('notadinas\softfile', $request->softfile, $fileRename);
            $lampiranDB = '/notadinas/softfile/'.$fileRename;
            $updatenotdin->softfile = $lampiranDB;
        }else{
            //Sukses RUN

            //jika terjadi perubahan terhadap perihal
            //rename id aja, gausah pake perihal yoi?gabsa karena belom dicreate
            if(isset($updatenotdin->softfile)){
                $fileRename = 'notadinas-'. $request->hal . '.pdf';
                //di explode (pisahin) dari tanda /  , array terakhir diganti sama perihal baru.pdf
                $pisah = explode('/',$updatenotdin->softfile);
                $nPisah = count($pisah);
                $pisah[$nPisah-1] = $fileRename;
                //reunite
                $dirfile = collect($pisah)->implode('/');
                //masukkin db > trus rename files
                
                if(Storage::disk('public')->exists($dirfile)){
                    $updatenotdin->softfile = $dirfile;
                }else{
                    //Storage::move('old/file.jpg', 'new/file.jpg');
                    Storage::disk('public')->move($updatenotdin->softfile, $dirfile);
                    $updatenotdin->softfile = $dirfile;
                }
                 
                
            }else{
                //tetep null
                $updatenotdin->softfile = $updatenotdin->softfile;
            }
            
        }

        //STATUS
        $updatenotdin->status = '1';
        //READ
        //PENERIMA
        $intDari = (integer)$request->dari;
        $cariId = Pegawai::where([ 'id_jabatan' => $intDari])->first();

        $updatenotdin->read = '1';
        $updatenotdin->id_penerima = $cariId->id;

        //koreksi
        $updatenotdin->koreksi = $request->koreksi;

        $updatenotdin->save();
        return redirect()->route('notadinas.edit', ['notadina' => $id])->with('success', 'Notadinas telah berhasil diupdate.');
    }

    //  public function update(NotaDinasRequest $request, NotaDinas $notdin)
    // {
    //     $notdin->update($request->input());
    //     return redirect()->route('inbox.index')->with('message','Nota Dinas Berhasil Diberi Nomor');
    // }

    // public function acc(NotaDinas $notdin)
    // {
    //     $notdin->id_status = '3';
    //     $notdin->save();
    //     return redirect()->route('inbox.index')->with('message','Nota Dinas Berhasil Disetujui');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //  public function destroy(NotaDinas $notdin)
    // {   
    //     app('App\Http\Controllers\KotakMasukController')->destroyNotdin($notdin->id);
    //     $notdin->delete();
    //     return redirect()->route('inbox.index')->with('message', 'Nota Dinas Berhasil Dihapus');
    // }

    public function delete (Request $request) 
    {
        //untuk delete dokumen(softfile/lampiran)
        $forDel = NotaDinas::where([ 'id' => $request->id])->first();
        if(isset($forDel->softfile)){
            Storage::disk('public')->delete($forDel->softfile); 
        }
        if(isset($forDel->lampiran)){
            Storage::disk('public')->delete($forDel->lampiran); 
        }    

        NotaDinas::find ( $request->id )->delete ();
        return response ()->json ();
    }

    public function showUpdate (Request $request)
    {   
        $data= $request->id;
  
     return response()->json($data);
    }

    //untuk multiple dropdown di update
    //convert id jabatan ke nama jabatan
    public static function vDropdown($id){
        //memisahkan Kepada menjadi array
        $jabatan = explode(',',$id);
        //menghitung jumlahnya
        $sumjabatan = count($jabatan);
        //counter
        $j=0;
        
        //mencari namajabatan di tabel jabatan dengan idjabatannya
        for($i = 0; $i < $sumjabatan; $i++){
            
            // $intJabatan[$i] = (integer)$jabatan[$i];

            //mengecek apakah ada data "Semua Kepala Bidang"
            if($jabatan[$i] == 6 ){
                //jika tidak kosong kepada di kepala bidang terakhir
                if(isset($jabatan[$i+4])){
                    //jika sesudahnya 10,14,18,22
                    if($jabatan[$i+1] == 10 && $jabatan[$i+2] == 14 && $jabatan[$i+3] == 18 && $jabatan[$i+4] == 22){
                        //maka ddKepada "Semua Kepala Bidang"
                        $ddKepada[$j] = "semua";
                        //counter $i maju
                        $i = $i + 4;
                    }else{
                        //maka diisi dengan id 6
                        $ddKepada[$j] = $jabatan[$i];
                    }
                }else{
                    //maka diisi dengan id 6
                    $ddKepada[$j] = $jabatan[$i];
                }

            }else{
                //jika bukan 6 maka diisi langsung dengan jabatan id
                $ddKepada[$j] = $jabatan[$i];
            }
                
            $j++;        
        }

        return $ddKepada;
    }

    public static function read($id){
        $updatenotdin = NotaDinas::find($id);
        // dieexplode dahulu
        $read=explode(',', $updatenotdin->read);
        $penerima=explode(',', $updatenotdin->id_penerima);
        // dicari di array indeks kebrapa jabaran user nya ini
        $i=0;
        $indeks;
        foreach ($penerima as $cek) {
            if($cek == (Auth::user()->id_jabatan)){
                $indeks = $i;
            }
            $i++;
        }

        $hasil = [];
        $hasil[0] = $read[$indeks];
        $hasil[1] = $indeks;

        return $hasil;
    }

    public static function count(){
        $notdin = NotaDinas::all();
        $count = count($notdin);

        return $count;
    }

}
