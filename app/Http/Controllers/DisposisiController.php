<?php

namespace App\Http\Controllers;

use Auth;
use App\Disposisi;
use App\Jabatan;
use App\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disposisi = Disposisi::all();
        return view ('disposisi.arsip', compact('disposisi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data= $request->id;
  
     return response()->json($data);
    }

    public function buatDispos($id)
    {
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        return view ('disposisi.buatdisposisi', compact('id', 'listJabatan'));
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
            'nomor_agenda' => 'string|max:50|unique:disposisis|nullable',
            'tgl_selesai' => 'date|nullable',
            'isi' => 'string|max:255|nullable',
            'catatan' => 'required|string|max:255',
            'disposisi' => 'required|string',
            'diteruskan' => 'required|string|max:255',
            'paraf' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
            'hardcopy' => 'required|string',
        ]);

        //olah data input yang perlu diproses dlu baru di create data

        //PARAF
        $now =  date('Y-m-d H:i:s'); // 2016-10-12 21:09:23
        $paraf = $request->paraf . "(" . $now . ")";
        $request->merge(['paraf' => $paraf]);

        //SOFTFILE
        //biar nama file uniq gimana
        // memroses file softfile
        $jabatanPembuat = Pegawai::where([ 'id' => $request->id_pembuat])->value('id_jabatan');
        $dari = Jabatan::where([ 'id' => $jabatanPembuat])->value('jabatan');
        if($temp = $request->hasFile('softfile')){
            //dipindahin via temp
            $temp = $request->file('softfile');
            $fileName = 'disposisi-'. $dari . '-' . 'id Surat Masuk-' . $request->id_surmas . '.' . $request->file('softfile')->getClientOriginalExtension();
            
            Storage::disk('public')->putFileAs('disposisi\softfile', $temp, $fileName);
            $fileDB = '/disposisi/softfile/'.$fileName;
            $request->merge(['softfile' => $fileDB]);
        }

        //id penerima
        $penerima = $request->diteruskan;
        $request->merge(['id_penerima' => $penerima]);

        //status
        $request->merge(['status' => '1']);

        $store = Disposisi::create($request->input());
        return redirect()->route('disposisi.show', Auth::user()->id)->with('success', 'Disposisi berhasil dibuat.');

        // return $now;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //buat nampilin smua data yang ada make show aja ga usah nambahin sent
        $disposisi = Disposisi::where([ 'id_pembuat' => $id])->get();
        // return $surmas;
        return view ('disposisi.terkirim', compact('disposisi'));
    }


    //convert id jabatan ke nama jabatan
    public static function descJabatan($id){
        //mencari namajabatan di tabel jabatan
        $namaJabatan = Jabatan::where([ 'id' => $id])->value('jabatan');

        return $namaJabatan;
    }


    public function showUpdate (Request $request)
    {   
        $data= $request->id;
  
     return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $dispos = Disposisi::where(['id' => $id])->get();
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        return view ('disposisi.update', compact('dispos', 'listJabatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nomor_agenda' => 'nullable|string|max:50|unique:disposisis,' . 'id',
            'tgl_selesai' => 'date|nullable',
            'isi' => 'string|max:255|nullable',
            'catatan' => 'required|string|max:255',
            'disposisi' => 'required|string',
            'diteruskan' => 'required|string|max:255',
            'paraf' => 'required|string|max:255',
            'softfile' => 'mimes:pdf',
            'hardcopy' => 'required|string',
        ]);

         //inisiasi surmas
        //mengambil surmas yang akan diupdate dari database
        $updatedisposisi = \App\Disposisi::find($id);

        //nomor agenda
        $updatedisposisi->nomor_agenda = $request->nomor_agenda;
        //tgl selesai
        $updatedisposisi->tgl_selesai = $request->tgl_selesai;
        //Ringkasan Isi
        $updatedisposisi->isi = $request->isi;
        //catatan
        $updatedisposisi->catatan = $request->catatan;
        //Disposisi
        $updatedisposisi->disposisi = $request->disposisi;
        //diteruskan
        $updatedisposisi->diteruskan = $request->diteruskan;
        //paraf
        $updatedisposisi->paraf = $request->paraf;
        //softfile
        $jabatanPembuat = Pegawai::where([ 'id' => $request->id_pembuat])->value('id_jabatan');
        $dari = Jabatan::where([ 'id' => $jabatanPembuat])->value('jabatan');
        if($request->hasFile('softfile')){
            //hapus softfile  yang lama jika ada
            if(isset($updatedisposisi->softfile)){
                Storage::disk('public')->delete($updatedisposisi->softfile);
            }

            $fileRename = 'disposisi-'. $dari . '-' . 'id Surat Masuk-' . $request->id_surmas . '.' . $request->file('softfile')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('disposisi\softfile', $request->softfile, $fileRename);
            $lampiranDB = '/disposisi/softfile/'.$fileRename;
            $updatedisposisi->softfile = $lampiranDB;
        }else{
                //tetep null
                $updatedisposisi->softfile = $updatedisposisi->softfile;
            
            
        }

        //id penerima
        $updatedisposisi->id_penerima = $request->diteruskan;

        //STATUS - READ - SURMAS - PENGINPUT
        $updatedisposisi->status = $request->status;
        $updatedisposisi->read = $request->read;
        $updatedisposisi->id_surmas = $request->id_surmas;
        $updatedisposisi->id_pembuat = $request->id_pembuat;

        $updatedisposisi->hardcopy = $request->hardcopy;

        $updatedisposisi->save();
        return redirect()->route('disposisi.edit', ['disposisi' => $id])->with('success', 'Disposisi telah berhasil diupdate.');
    }

    public function delete (Request $request) 
    {
        //untuk delete dokumen(softfile/lampiran)
        $forDel = Disposisi::where([ 'id' => $request->id])->first();
        if(isset($forDel->softfile)){
            Storage::disk('public')->delete($forDel->softfile); 
        } 

        Disposisi::find( $request->id )->delete();
        return response()->json();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disposisi $disposisi)
    {
        //
    }

    public static function count(){
        $dispos = Disposisi::all();
        $count = count($dispos);

        return $count;
    }
}
