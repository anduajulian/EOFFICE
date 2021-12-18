<?php

namespace App\Http\Controllers;

use Auth;
use App\SuratMasuk;
use App\SuratKeluar;
use App\NotaDinas;
use App\Disposisi;
use App\Jabatan;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
    	//menampilkan semua yang id_penerima == auth->id_jabatan
    	//suratmasuk
    	$surmas = SuratMasuk::where([ 'id_penerima' => (Auth::user()->id_jabatan)])->get();
    	//suratkeluar
    	$surkel = SuratKeluar::where([ 'id_penerima' => (Auth::user()->id_jabatan)])->get();

    	//notadinas
    	//harus diexplode dlu baru dijadiin array
    	$nota = NotaDinas::all();
    	//buat kounter dan buat variabel untuk simpen id yg penerimanya ada id_jabatan user
    	$j = 0;
    	$idnotdin = [];
    	foreach ($nota as $cek){
    	 // jadi pas ketemu penerima == id jabatan
    		if(isset($cek->id_penerima)){
	    		$penerima = explode(',', $cek->id_penerima);
	    		$sum = count($penerima);

	    		for($i=0;$i<$sum;$i++){
	    			if((Auth::user()->id_jabatan) == $penerima[$i]){
	    				//maka notadinas dimasukkan ke variabel, caranya gimanaaaa?
	    				//atau bisa juga dikumpulin id notadinasnya trus ntar tinggal diquery, kayanya lebih enak--->make ini dan works,, alhamdulillah
	    				
	    				$idnotdin[$j] = $cek->id;
	    				$j++;
	    			}

	    		}
    		}

    	}
    	//jika usernya idjabatanya ada di notadinas maka notdin berisikan notadinas yg penerima nya dia
    	if(isset($idnotdin)){
    		$notdin = NotaDinas::whereIn('id', $idnotdin)->get();
    	}else{
    		$notdin;
    	}

    	//disposisi
        $disposisi = Disposisi::where([ 'id_penerima' => (Auth::user()->id_jabatan)])->get();

        return view ('inbox', compact('surmas', 'surkel', 'notdin', 'disposisi'));
        // return $disposisi;
    }
// tinggal ditambahin view masing2 surat + action button per role
    public function openSurmas($id)
    {
        //disni kita rubah status read
        $updatesurmas = SuratMasuk::find($id);
        //jika belom diread
        if($updatesurmas->read == 1){
            //maka berubah 0 = sudah diread
            $updatesurmas->read = 0;
            $updatesurmas->save();
        }
        
        $surmas = SuratMasuk::where(['id' => $id])->get();
        
        return view ('surmas.open', compact('surmas'));

    }

    public function openSurkel($id)
    {
        //disni kita rubah status read
        $updatesurkel = SuratKeluar::find($id);
        //jika belom diread
        if($updatesurkel->read == 1){
            //maka berubah 0 = sudah diread
            $updatesurkel->read = 0;
            $updatesurkel->save();
        }
        
        $surkel = SuratKeluar::where(['id' => $id])->get();
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();
        
        return view ('surkel.open', compact('surkel', 'listJabatan'));
    }

    public function openNotdin($id)
    {
        //disni kita rubah status read
        $updatenotdin = NotaDinas::find($id);
        // dieexplode dahulu
        $read=explode(',', $updatenotdin->read);
        $indeks = NotaDinasController::read($id);
    
        //jika belom diread
        if($read[$indeks[1]] == 1){
            //maka berubah 0 = sudah diread
            $read[$indeks[1]] = 0;
            $read=implode(',', $read);
            $updatenotdin->read = $read;
            $updatenotdin->save();
        }
        //kalo mau lebih rapih ada function buat get nilai Read dan Indeks
        
        $notdin = NotaDinas::where(['id' => $id])->get();
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();

        return view ('notdin.open', compact('notdin', 'listJabatan'));
    }

    public function openDisposisi($id)
    {
         //disni kita rubah status read
        $updatedispos = Disposisi::find($id);
        //jika belom diread
        if($updatedispos->read == 1){
            //maka berubah 0 = sudah diread
            $updatedispos->read = 0;
            $updatedispos->save();
        }
        
        $dispos = Disposisi::where(['id' => $id])->get();
        $listJabatan = app(\App\Http\Controllers\JabatanController::class)->register();

        return view ('disposisi.open', compact('dispos', 'listJabatan'));
    }

    public function approveSurmas($id){
        $updatesurmas = SuratMasuk::find($id);
        $updatesurmas->status = 2;
        $updatesurmas->id_penerima = 1;
        $updatesurmas->read = 1;
        $updatesurmas->save();

        return redirect()->route('inbox.index');
    }

    public function approveSurkel($id){
        $updatesurkel = SuratKeluar::find($id);

        if((Auth::user()->id_jabatan) == 1){
            $updatesurkel->status = 2;
            $updatesurkel->read = 1;
            $updatesurkel->id_penerima = 4;
        }else{
            if(isset($updatesurkel->nomor)){
                $updatesurkel->status = 4;
                $updatesurkel->read = 1;
                $updatesurkel->id_penerima = $updatesurkel->id_pembuat;
            }else{
                $updatesurkel->status = 3;
                $updatesurkel->read = 1;
                $updatesurkel->id_penerima = 1;
            }
        }
        
        $updatesurkel->save();

        return redirect()->route('inbox.index');
    }

    public function approveNotdin($id){
        $updatenotdin = NotaDinas::find($id);

        if((Auth::user()->id_jabatan) == $updatenotdin->dari){
            $updatenotdin->status = 2;
            $updatenotdin->read = 1;
            $updatenotdin->id_penerima = 4;
        }else{
            $updatenotdin->status = 3;
            $updatenotdin->id_penerima = $updatenotdin->kepada;
            $sum = explode(',', $updatenotdin->kepada);
            $read = [];
            $i = 0;

            foreach ($sum as $key) {
                $read[$i] = 1;
                $i++;
            }

            $fixread = collect($read)->implode(',');

            $updatenotdin->read = $fixread;
        }

        $updatenotdin->save();

        return redirect()->route('inbox.index');
    }

    public function approveDisposisi(Request $request, $id){
        $this->validate($request, [
            'hardcopy' => 'required|string'
        ]);
        $updatedispos = Disposisi::find($id);
        $updatedispos->status = 3;
        $updatedispos->hardcopy = $request->hardcopy;
        $updatedispos->save();

        return redirect()->route('inbox.index');
    }

    public function rejectSurkel(Request $request, $id){

        $this->validate($request, [
            'koreksi' => 'string|max:255|nullable',
        ]);

        $updatesurkel = SuratKeluar::find($id);

        $updatesurkel->status = 5;
        $updatesurkel->read = 1;
        $updatesurkel->id_penerima = $updatesurkel->id_pembuat;
        $updatesurkel->koreksi = $request->koreksi;
        
        $updatesurkel->save();

        return redirect()->route('inbox.index');
    }

    public function rejectNotdin(Request $request, $id){
        $this->validate($request, [
            'koreksi' => 'string|max:255|nullable',
        ]);

        $updatenotdin = NotaDinas::find($id);

        $updatenotdin->status = 5;
        $updatenotdin->read = 1;
        $updatenotdin->id_penerima = $updatenotdin->id_pembuat;
        $updatenotdin->koreksi = $request->koreksi;

        $updatenotdin->save();

        return redirect()->route('inbox.index');
    }

    public function fwdDisposisi(Request $request, $id){
        $this->validate($request, [
            'catatan' => 'required|string|max:255',
            'diteruskan' => 'required|string|max:255',
            'hardcopy' => 'required|string'
        ]);

        $updatedispos = Disposisi::find($id);

        $updatedispos->catatan = $request->catatan;
        $updatedispos->diteruskan = $request->diteruskan;
        $updatedispos->id_penerima = $request->diteruskan;
        $updatedispos->status = 2;
        $updatedispos->read = 1;
        $updatedispos->hardcopy = $request->hardcopy;

        $updatedispos->save();

        return redirect()->route('inbox.index');
    }

    public static function unread()
    {

        //suratmasuk
        $surmas = SuratMasuk::where([ 'id_penerima' => (Auth::user()->id_jabatan)])->get();
        //suratkeluar
        $surkel = SuratKeluar::where([ 'id_penerima' => (Auth::user()->id_jabatan)])->get();
        //notadinas
        $nota = NotaDinas::all();
        //buat kounter dan buat variabel untuk simpen id yg penerimanya ada id_jabatan user
        $j = 0;
        $idnotdin = [];
        foreach ($nota as $cek){
         // jadi pas ketemu penerima == id jabatan
            if(isset($cek->id_penerima)){
                $penerima = explode(',', $cek->id_penerima);
                $sum = count($penerima);

                for($i=0;$i<$sum;$i++){
                    if((Auth::user()->id_jabatan) == $penerima[$i]){  
                        $idnotdin[$j] = $cek->id;
                        $j++;
                    }

                }
            }

        }
        //jika usernya idjabatanya ada di notadinas maka notdin berisikan notadinas yg penerima nya dia
        if(isset($idnotdin)){
            $notdin = NotaDinas::whereIn('id', $idnotdin)->get();
        }else{
            $notdin;
        }
        //disposisi
        $disposisi = Disposisi::where([ 'id_penerima' => (Auth::user()->id_jabatan)])->get();
        
        // count inbox yg unread
        $unread=0;
        foreach ($surmas as $cek) {
            if($cek->read == 1){
                $unread++;
            }
        }
        foreach ($surkel as $cek) {
            if($cek->read == 1){
                $unread++;
            }
        }
        //harus dibenerin karena penerima lebih dari satu sama benerin di inbox.blade ------------------------
        
        foreach ($notdin as $cek) {
            $read = NotaDinasController::read($cek->id);
            if($read[0] == 1){
                $unread++;
            }
        }
        foreach ($disposisi as $cek) {
            if($cek->read == 1){
                $unread++;
            }
        }

        return $unread;
    }
}
