<?php

namespace App\Http\Controllers;

use App\Pegawai;
use App\Jabatan;
use Illuminate\Http\Request;

class EditShowPegawai extends Controller
{
    public function index()
    {
        // $listnotdin = NotaDinas::all();
        // return view ('notadinas', compact('listnotdin'));
        $peg = Pegawai::all();

        // return view ('list', compact('peg'));
        return view ('auth.listuser', compact('peg'));
    }

    public static function jabs($id){
    	$jabatan = Jabatan::where([ 'id' => $id])->value('jabatan');

    	return $jabatan;
    }

    public function showUpdate (Request $request)
    {   
        $data= $request->id;
  
     return response()->json($data);
    }

    public function edit($id)
    {   
        $user = Pegawai::where(['id' => $id])->get();
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        return view ('auth.update', compact('user', 'listJabatan'));
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'nip' => 'required|string|max:50|unique:pegawais,'. 'id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15|unique:pegawais,'. 'id',
            'jenis_kelamin' => 'required|string',
            'id_jabatan' => 'required|integer',
            'username' => 'required|unique:pegawais,'. 'id',
            'email' => 'required|string|email|max:255|unique:pegawais,'. 'id',
        ]);

        $updateuser = Pegawai::find($id);

        $updateuser->nip = $request->nip;
        $updateuser->nama = $request->nama;
        $updateuser->alamat = $request->alamat;
        $updateuser->telepon = $request->telepon;
        $updateuser->jenis_kelamin = $request->jenis_kelamin;
        $updateuser->id_jabatan = $request->id_jabatan;
        $updateuser->username = $request->username;
        $updateuser->email = $request->email;

        $updateuser->save();
        return redirect()->route('user.edit', ['user' => $id])->with('success', 'Data Pegawai telah berhasil diupdate.');
    }

    public function delete (Request $request) 
    {
        Pegawai::find( $request->id )->delete();

        return response()->json();
    }

}
