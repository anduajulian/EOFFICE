@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">Edit Pegawai</h1>
                <!-- declare isi dari notadinas -->
                @foreach($user as $notnot)
                @endforeach
                <!-- {{$notnot->kepada}} -->
                

                <div class="card-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger">
                      @foreach ($errors->all() as $error)
                      {{ $error }} <br/>
                      @endforeach
                    </div>
                    @endif

                    @if( ! empty( ! empty( $success_msg = session( 'success' ) ) ) )
                          <div class="alert alert-dismissible alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <p>{{$success_msg}}</p>
                          </div>
                    @endif
                    
                    <form method="POST" action="{{ route('user.update', $notnot->id) }}" aria-label="{{ __('Edit Pegawai') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">NIP</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nip') ? ' is-invalid' : '' }}" name="nip" value="{{$notnot->nip}}"  required>

                               @if ($errors->has('nip'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('nip') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Nama</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" value="{{$notnot->nama}}"  required>

                               @if ($errors->has('nama'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('nama') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Alamat</label>
                            <div class="col-md-6">
                               <textarea type="text" class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ $notnot->alamat }}" required>{{$notnot->alamat}}</textarea>

                               @if ($errors->has('alamat'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('alamat') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Telepon</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('telepon') ? ' is-invalid' : '' }}" name="telepon" value="{{ $notnot->telepon }}" required>

                               @if ($errors->has('telepon'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('telepon') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Jenis Kelamin</label>
                            <div class="col-md-6">
                                <select  name="jenis_kelamin" class="form-control{{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" required>
                                  
                                  <option disabled @if(empty($notnot->jenis_kelamin)) selected @endif value> -- select an option -- </option>
                                  <option value="pria" @if($notnot->jenis_kelamin == "pria") selected @endif> Pria </option>
                                  <option value="wanita" @if($notnot->jenis_kelamin == "wanita") selected @endif> Wanita </option>
                                </select>

                                @if ($errors->has('jenis_kelamin'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('jenis_kelamin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Jabatan</label>

                            <div class="col-md-6">
                                    @if(isset($listJabatan))
                                    <select class="form-control{{ $errors->has('id_jabatan') ? ' is-invalid' : '' }}" name="id_jabatan" required>
                                        
                                          <option disabled @if(empty($notnot->id_jabatan)) selected @endif value> -- select an option -- </option>
                                          @foreach($listJabatan as $listjabatan)
                                            
                                            <option value="{{$listjabatan->id}}" @if($notnot->id_jabatan == $listjabatan->id) selected @endif>{{ $listjabatan->jabatan }}</option>
                                            
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
                           <label class="col-md-4 col-form-label text-md-right">Username</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $notnot->username }}" required>

                               @if ($errors->has('username'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('username') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $notnot->email }}" required>

                               @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>
                      
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Data Pegawai') }}
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
