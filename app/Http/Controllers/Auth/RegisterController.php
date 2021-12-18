<?php

namespace App\Http\Controllers\Auth;

use App\Pegawai;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new pegawais as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect pegawai after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nip' => 'required|string|max:50|unique:pegawais',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15|unique:pegawais',
            'jenis_kelamin' => 'required|string',
            'id_jabatan' => 'required|integer',
            'username' => 'required|unique:pegawais',
            'email' => 'required|string|email|max:255|unique:pegawais',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new pegawai instance after a valid registration.
     *
     * @param  array  $data
     * @return \E-Office\Pegawai
     */
    protected function create(array $data)
    {
        return Pegawai::create([
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'id_jabatan' => $data['id_jabatan'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

}