@extends('homelogin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">NIP</label>
                           
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" value="{{ old('nip') }}" onkeypress="return isNumber(event)" required >

                               @if ($errors->has('nip'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('nip') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label text-md-right">Nama</label>

                            <div class="col-md-6">
                                <input id="nama" type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="" required>

                                @if ($errors->has('nama'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label for="alamat" class="col-md-4 col-form-label text-md-right">Alamat</label>

                            <div class="col-md-6">
                               <textarea id="alamat" type="text" class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ old('alamat') }}" required ></textarea>

                               @if ($errors->has('alamat'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('alamat') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telepon" class="col-md-4 col-form-label text-md-right">Telepon</label>

                            <div class="col-md-6">
                                <input id="telepon" type="text" class="form-control{{ $errors->has('telepon') ? ' is-invalid' : '' }}" name="telepon" value="{{ old('telepon') }}" required onkeypress="return isNumber(event)">

                                @if ($errors->has('telepon'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telepon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-md-4 col-form-label text-md-right">Jenis Kelamin</label>

                            <div class="col-md-6">
                                <select id="jenis_kelamin" type="text" class="form-control{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" name="jenis_kelamin" required>
                                  <option value="pria">Pria</option>
                                  <option value="wanita">Wanita</option>
                                </select>

                                @if ($errors->has('jenis_kelamin'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('jenis_kelamin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_jabatan" class="col-md-4 col-form-label text-md-right">Jabatan</label>

                            <div class="col-md-6">
                                    @if(isset($listJabatan))
                                    <select id="id_jabatan" class="form-control{{ $errors->has('id_jabatan') ? ' is-invalid' : '' }}" name="id_jabatan" required>
                                        @foreach($listJabatan as $listjabatan)
                                            <option value="{{$listjabatan->id}}">{{ $listjabatan->jabatan }}</option>
                                        @endforeach
                                      
                                  
                                     </select>
                                    @else
                                        <label >Database Kosyong</label>
                                    @endif  

                                @if ($errors->has('id_jabatan'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('id_jabatan') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                               <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}">

                               @if ($errors->has('username'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('username') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
