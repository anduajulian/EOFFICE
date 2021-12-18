<?php

namespace App\Http\Controllers;

use Auth;
use App\SuratKeluar;
use App\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surkel = SuratKeluar::all();
        return view ('surkel.arsip', compact('surkel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        return view ('surkel.buatsurkel', compact('listJabatan'));
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
            'nomor' => 'string|max:50|unique:surat_keluars|nullable',
            'kepada' => 'required|string|max:255',
            'dari' => 'required|string|max:255',
            'tembusan' => 'array|nullable',
            'tanggal' => 'required|date',
            'sifat' => 'required|string',
            'lampiran' => 'mimes:pdf|nullable',
            'hal' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
            'koreksi' => 'string|max:255|nullable',
        ]);

        //TEMBUSAN
        // menyatukan/implode semua "tembusan" menjadi satu string
        if(isset($request->tembusan) && is_array($request->tembusan)){
            $alltembusan = collect($request->tembusan)->implode(',');
            $request->merge(['tembusan' => $alltembusan]);
        }

        //LAMPIRAN
        // memroses file lampiran
        $dari = Jabatan::where([ 'id' => $request->dari])->value('jabatan');
        if($request->hasFile('lampiran')){
           
            $fileRename = 'suratkeluar-'. $dari . '-' . $request->hal . '.' . $request->file('lampiran')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('suratkeluar\lampiran', $request->lampiran, $fileRename);
            $lampiranDB = '/suratkeluar/lampiran/'.$fileRename;
            $request->merge(['lampiran' => $lampiranDB]);
            
        }

        //SOFTFILE
        // memroses file softfile
        if($request->hasFile('softfile')){
           
            $fileRename = 'suratkeluar-'. $dari . '-' . $request->hal . '.' . $request->file('softfile')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('suratkeluar\softfile', $request->softfile, $fileRename);
            $softfileDB = '/suratkeluar/softfile/'.$fileRename;
            $request->merge(['softfile' => $softfileDB]);
            
        }

        //menentukan id penerima&&status
        if( (Auth::user()->id_jabatan) == 4 ){
            $request->merge(['status' => '2']);
            $request->merge(['id_penerima' => '1']);
        }else if((Auth::user()->id_jabatan) == 1){
            $request->merge(['status' => '3']);
            $request->merge(['id_penerima' => '2']);
        }else if((Auth::user()->id_jabatan) == 2){
            $request->merge(['status' => '4']);
            $request->merge(['id_penerima' => (Auth::user()->id_jabatan)]);
        }else{
            $request->merge(['status' => '1']);
            $request->merge(['id_penerima' => '4']);
        }

        //READ
        $request->merge(['read' => '1']);

        $store = SuratKeluar::create($request->input());
        return redirect()->route('suratkeluar.show', Auth::user()->id)->with('success', 'Surat Keluar berhasil dibuat.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //buat nampilin smua data yang ada make show aja ga usah nambahin sent
        $surkel = SuratKeluar::where([ 'id_pembuat' => $id])->get();
        return view ('surkel.terkirim', compact('surkel'));
    }

    //convert id jabatan ke nama jabatan
    public static function descJabatan($id){
        //mencari namajabatan di tabel jabatan
        $namaJabatan = Jabatan::where([ 'id' => $id])->value('jabatan');

        return $namaJabatan;
    }

    public function delete (Request $request) 
    {
        //untuk delete dokumen(softfile/lampiran)
        $forDel = SuratKeluar::where([ 'id' => $request->id])->first();
        if(isset($forDel->softfile)){
            Storage::disk('public')->delete($forDel->softfile); 
        }
        if(isset($forDel->lampiran)){
            Storage::disk('public')->delete($forDel->lampiran); 
        }    

        SuratKeluar::find( $request->id )->delete();
        return response()->json();
    }

    public function showUpdate (Request $request)
    {   
        $data= $request->id;
  
     return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surkel = SuratKeluar::where(['id' => $id])->get();
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        return view ('surkel.update', compact('surkel', 'listJabatan'));
    }

    //misahin jadi array
    public static function multiTembusan($id){
        
        $tembusan = explode(',',$id);

        return $tembusan;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nomor' => 'nullable|string|max:50|unique:surat_keluars,' . 'id',
            'kepada' => 'required|string|max:255',
            'dari' => 'required|string|max:255',
            'tembusan' => 'array|nullable',
            'tanggal' => 'required|date',
            'sifat' => 'required|string',
            'lampiran' => 'mimes:pdf|nullable',
            'hal' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
            'koreksi' => 'string|max:255|nullable',
        ]);

        //inisiasi suratkeluar
        //mengambil suratkeluar yang akan diupdate dari database
        $updatesurkel = \App\SuratKeluar::find($id);

        //nomor
        $updatesurkel->nomor = $request->nomor;
        //kepada
        $updatesurkel->kepada = $request->kepada;
        //dari
        $updatesurkel->dari = $request->dari;
        //tembusan
        if(isset($request->tembusan) && is_array($request->tembusan)){
            $alltembusan = collect($request->tembusan)->implode(',');
            $updatesurkel->tembusan = $alltembusan;
        }
        //tanggal
        $updatesurkel->tanggal = $request->tanggal;
        //sifat
        $updatesurkel->sifat = $request->sifat;
        //lampiran
        $dari = Jabatan::where([ 'id' => $request->dari])->value('jabatan');
        if($request->hasFile('lampiran')){
            //hapus lampiran yang lama jika ada
            if(isset($updatesurkel->lampiran)){
                Storage::disk('public')->delete($updatesurkel->lampiran);
            }

            $fileRename = 'suratkeluar-'. $dari . '-' . $request->hal . '.' . $request->file('lampiran')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('suratkeluar\lampiran', $request->lampiran, $fileRename);
            $lampiranDB = '/suratkeluar/lampiran/'.$fileRename;
            $updatesurkel->lampiran = $lampiranDB;
        }else{
            //jika terjadi perubahan terhadap perihal dan dari
            if(isset($updatesurkel->lampiran)){
                $fileRename = 'suratkeluar-' . $dari . '-' . $request->hal . '.pdf';
                //di explode (pisahin) dari tanda /  , array terakhir diganti sama perihal baru.pdf
                $pisah = explode('/',$updatesurkel->lampiran);
                $nPisah = count($pisah);
                $pisah[$nPisah-1] = $fileRename;
                //reunite
                $dirfile = collect($pisah)->implode('/');
                //masukkin db > trus rename files
                
                //jika perihal dan dari tidak berubah
                if(Storage::disk('public')->exists($dirfile)){
                    $updatesurkel->lampiran = $dirfile;
                //jika perihal dan dari berubah
                }else{
                    //Storage::move('old/file.jpg', 'new/file.jpg');
                    Storage::disk('public')->move($updatesurkel->lampiran, $dirfile);
                    $updatesurkel->lampiran = $dirfile;
                }
                 
                
            }else{
                //tetep null atau yg lama
                $updatesurkel->lampiran = $updatesurkel->lampiran;
            }
        }

        //hal
        $updatesurkel->hal = $request->hal;

        //softfile
        if($request->hasFile('softfile')){
            //hapus softfile yang lama jika ada
            if(isset($updatesurkel->softfile)){
                Storage::disk('public')->delete($updatesurkel->softfile);
            }

            $fileRename = 'suratkeluar-'. $dari . '-' . $request->hal . '.' . $request->file('softfile')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('suratkeluar\softfile', $request->softfile, $fileRename);
            $softfileDB = '/suratkeluar/softfile/'.$fileRename;
            $updatesurkel->softfile = $softfileDB;
        }else{
            //jika terjadi perubahan terhadap perihal dan dari
            if(isset($updatesurkel->softfile)){
                $fileRename = 'suratkeluar-' . $dari . '-' . $request->hal . '.pdf';
                //di explode (pisahin) dari tanda /  , array terakhir diganti sama perihal baru.pdf
                $pisah = explode('/',$updatesurkel->softfile);
                $nPisah = count($pisah);
                $pisah[$nPisah-1] = $fileRename;
                //reunite
                $dirfile = collect($pisah)->implode('/');
                //masukkin db > trus rename files
                
                //jika perihal dan dari tidak berubah
                if(Storage::disk('public')->exists($dirfile)){
                    $updatesurkel->softfile = $dirfile;
                //jika perihal dan dari berubah
                }else{
                    //Storage::move('old/file.jpg', 'new/file.jpg');
                    Storage::disk('public')->move($updatesurkel->softfile, $dirfile);
                    $updatesurkel->softfile = $dirfile;
                }
                 
                
            }else{
                //tetep null atau yg lama
                $updatesurkel->softfile = $updatesurkel->softfile;
            }
        }

        //koreksi
        $updatesurkel->koreksi = $request->koreksi;
        //id penerima dan status
        if( (Auth::user()->id_jabatan) == 4 ){
            $updatesurkel->id_penerima = '1';
            $updatesurkel->status = '2';
        }else if((Auth::user()->id_jabatan) == 1){
            $updatesurkel->id_penerima = '2';
            $updatesurkel->status = '3';
        }else if((Auth::user()->id_jabatan) == 2){
            $updatesurkel->id_penerima = (Auth::user()->id_jabatan);
            $updatesurkel->status = '4';
        }else{
            $updatesurkel->id_penerima = '4';
            $updatesurkel->status = '1';
        }
        //id pembuat
        $updatesurkel->id_pembuat = $updatesurkel->id_pembuat;
        //read
        $updatesurkel->read = '1';

        $updatesurkel->save();
        return redirect()->route('suratkeluar.edit', ['suratkeluar' => $id])->with('success', 'Surat Keluar telah berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        //
    }

    public static function count(){
        $surkel = SuratKeluar::all();
        $count = count($surkel);

        return $count;
    }
}
