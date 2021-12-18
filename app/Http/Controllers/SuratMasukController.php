<?php

namespace App\Http\Controllers;

use Auth;
use App\Pegawai;
use App\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surmas = SuratMasuk::all();
        return view ('surmas.arsip', compact('surmas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('surmas.buatsurmas');
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
            'nomor' => 'required|string|max:50|unique:surat_masuks',
            'kepada' => 'required|string|max:255',
            'dari' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'sifat' => 'required|string',
            'lampiran' => 'mimes:pdf|nullable',
            'hal' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
        ]);

        //LAMPIRAN
        // memroses file lampiran
        if($request->hasFile('lampiran')){
           
            $fileRename = 'suratmasuk-'. $request->dari . '-' . $request->tanggal . '.' . $request->file('lampiran')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('suratmasuk\lampiran', $request->lampiran, $fileRename);
            $lampiranDB = '/suratmasuk/lampiran/'.$fileRename;
            $request->merge(['lampiran' => $lampiranDB]);
            
        }

        //SOFTFILE
        // memroses file softfile
        if($temp = $request->hasFile('softfile')){
            //dipindahin via temp
            $temp = $request->file('softfile');
            $fileName = 'suratmasuk-'. $request->dari . '-' . $request->tanggal . '.' . $request->file('softfile')->getClientOriginalExtension();
            
            Storage::disk('public')->putFileAs('suratmasuk\softfile', $temp, $fileName);
            $fileDB = '/suratmasuk/softfile/'.$fileName;
            $request->merge(['softfile' => $fileDB]);
        }

        //menentukan id penerima&&status
        if( (Auth::user()->id_jabatan) != 4 ){
            $request->merge(['status' => '1']);
            $request->merge(['id_penerima' => '4']);
        }else{
            $request->merge(['status' => '2']);
            $request->merge(['id_penerima' => '1']);
        }

        $store = SuratMasuk::create($request->input());
        return redirect()->route('suratmasuk.show', Auth::user()->id)->with('success', 'Surat Masuk berhasil dibuat.');
        // return $request; 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //buat nampilin smua data yang ada make show aja ga usah nambahin sent
        $surmas = SuratMasuk::where([ 'id_pembuat' => $id])->get();
        // return $surmas;
        return view ('surmas.terkirim', compact('surmas'));
    }

    public function delete (Request $request) 
    {
        //untuk delete dokumen(softfile/lampiran)
        $forDel = SuratMasuk::where([ 'id' => $request->id])->first();
        if(isset($forDel->softfile)){
            Storage::disk('public')->delete($forDel->softfile); 
        }
        if(isset($forDel->lampiran)){
            Storage::disk('public')->delete($forDel->lampiran); 
        }    

        SuratMasuk::find( $request->id )->delete();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surmas = SuratMasuk::where(['id' => $id])->get();
        
        return view ('surmas.update', compact('surmas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nomor' => 'required|string|max:50|unique:surat_masuks,' . 'id',
            'kepada' => 'required|string|max:255',
            'dari' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'sifat' => 'required|string',
            'lampiran' => 'mimes:pdf|nullable',
            'hal' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
        ]);

        //inisiasi surmas
        //mengambil surmas yang akan diupdate dari database
        $updatesurmas = \App\SuratMasuk::find($id);

        //nomor
        $updatesurmas->nomor = $request->nomor;
        //kepada
        $updatesurmas->kepada = $request->kepada;
        //dari
        $updatesurmas->dari = $request->dari;
        //tanggal
        $updatesurmas->tanggal = $request->tanggal;
        //sifat
        $updatesurmas->sifat = $request->sifat;
        //hal atau perihal
        $updatesurmas->hal = $request->hal;

        //lampiran
        // tetep diproses walau ada perubahan/tidak pada perihal, tetep di rename
        // kondisinya tetep perubahan di file atau engga
        if($request->hasFile('lampiran')){
            //hapus lampiran yang lama jika ada
            if(isset($updatesurmas->lampiran)){
                Storage::disk('public')->delete($updatesurmas->lampiran);
            }

            $fileRename = 'suratmasuk-'. $request->dari . '-' . $request->tanggal . '.' . $request->file('lampiran')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('suratmasuk\lampiran', $request->lampiran, $fileRename);
            $lampiranDB = '/suratmasuk/lampiran/'.$fileRename;
            $updatesurmas->lampiran = $lampiranDB;
        }else{
            //Sukses RUN kecuali sblumnya NULL------------------------------------------------------------- 

            //jika terjadi perubahan terhadap perihal
            //rename id aja, gausah pake perihal yoi?gabsa karena belom dicreate
            if(isset($updatesurmas->lampiran)){
                $fileRename = 'suratmasuk-'. $request->dari . '-' . $request->tanggal . '.pdf';
                //di explode (pisahin) dari tanda /  , array terakhir diganti sama perihal baru.pdf
                $pisah = explode('/',$updatesurmas->lampiran);
                $nPisah = count($pisah);
                $pisah[$nPisah-1] = $fileRename;
                //reunite
                $dirfile = collect($pisah)->implode('/');
                //masukkin db > trus rename files
                
                //jika perihal tidak berubah
                if(Storage::disk('public')->exists($dirfile)){
                    $updatesurmas->lampiran = $dirfile;
                }else{
                    //Storage::move('old/file.jpg', 'new/file.jpg');
                    Storage::disk('public')->move($updatesurmas->lampiran, $dirfile);
                    $updatesurmas->lampiran = $dirfile;
                }
                 
                
            }else{
                //tetep null
                $updatesurmas->lampiran = $updatesurmas->lampiran;
            }
            
        }        

        //softfile
        if($request->hasFile('softfile')){
            //hapus softfile  yang lama jika ada
            if(isset($updatesurmas->softfile)){
                Storage::disk('public')->delete($updatesurmas->softfile);
            }

            $fileRename = 'suratmasuk-'. $request->dari . '-' . $request->tanggal . '.' . $request->file('softfile')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('suratmasuk\softfile', $request->softfile, $fileRename);
            $lampiranDB = '/suratmasuk/softfile/'.$fileRename;
            $updatesurmas->softfile = $lampiranDB;
        }else{
            //Sukses RUN

            //jika terjadi perubahan terhadap perihal
            //rename id aja, gausah pake perihal yoi?gabsa karena belom dicreate
            if(isset($updatesurmas->softfile)){
                $fileRename = 'suratmasuk-'. $request->dari . '-' . $request->tanggal . '.pdf';
                //di explode (pisahin) dari tanda /  , array terakhir diganti sama perihal baru.pdf
                $pisah = explode('/',$updatesurmas->softfile);
                $nPisah = count($pisah);
                $pisah[$nPisah-1] = $fileRename;
                //reunite
                $dirfile = collect($pisah)->implode('/');
                //masukkin db > trus rename files
                
                if(Storage::disk('public')->exists($dirfile)){
                    $updatesurmas->softfile = $dirfile;
                }else{
                    //Storage::move('old/file.jpg', 'new/file.jpg');
                    Storage::disk('public')->move($updatesurmas->softfile, $dirfile);
                    $updatesurmas->softfile = $dirfile;
                }
                 
                
            }else{
                //tetep null
                $updatesurmas->softfile = $updatesurmas->softfile;
            }
            
        }

        //STATUS - READ - PENERIMA - PENGINPUT
        $updatesurmas->status = '1';
        $updatesurmas->read = $request->read;
        $updatesurmas->id_penerima = '4';
        $updatesurmas->id_pembuat = $request->id_pembuat;

        $updatesurmas->save();
        return redirect()->route('suratmasuk.edit', ['suratmasuk' => $id])->with('success', 'Surat Masuk Dinas telah berhasil diupdate.');
        // return $request;
    }

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

    public static function count(){
        $surmas = SuratMasuk::all();
        $count = count($surmas);

        return $count;
    }
}
