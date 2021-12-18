@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">Buat Surat Masuk</h1>

                <div class="card-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger">
                      @foreach ($errors->all() as $error)
                      {{ $error }} <br/>
                      @endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('suratmasuk.store') }}" aria-label="{{ __('Buat Surat Masuk') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Nomor</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nomor') ? ' is-invalid' : '' }}" name="nomor" value="{{ old('nomor') }}" required >

                               @if ($errors->has('nomor'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('nomor') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Kepada</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('kepada') ? ' is-invalid' : '' }}" name="kepada" value="{{ old('kepada') }}" required>

                               @if ($errors->has('kepada'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('kepada') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Dari</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('dari') ? ' is-invalid' : '' }}" name="dari" value="{{ old('dari') }}" required>

                               @if ($errors->has('dari'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('dari') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Tanggal</label> 
                            <div class="col-md-6">
                               <input type="date" class="form-control{{ $errors->has('tanggal') ? ' is-invalid' : '' }}" name="tanggal" value="{{ old('tanggal') }}" required>

                               @if ($errors->has('tanggal'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('tanggal') }}</strong>
                                  </span>
                               @endif
                            </div>    
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Sifat</label>
                            <div class="col-md-6">
                                <select  name="sifat" class="form-control{{ $errors->has('sifat') ? ' is-invalid' : '' }}" required>
                                  <option disabled selected value> -- select an option -- </option>
                                  <option value="biasa">Biasa</option>
                                  <option value="rahasia">Rahasia</option>
                                  <option value="sangat_segera">Sangat Segera</option>
                                </select>

                                @if ($errors->has('sifat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sifat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Lampiran</label>
                            <div class="col-md-6">
                               <input type="file" name="lampiran">

                               @if ($errors->has('lampiran'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('lampiran') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Hal</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('hal') ? ' is-invalid' : '' }}" name="hal" value="{{ old('hal') }}" required>

                               @if ($errors->has('hal'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('hal') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Soft File</label>
                            <div class="col-md-6">
                               <input type="file" name="softfile" required>

                               @if ($errors->has('softfile'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('softfile') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                         <input type="hidden" name="id_penerima" value="">
                         <input type="hidden" id="id_pembuat" name="id_pembuat" value="{{ Auth::user()->id }}">
                         <input type="hidden" id="status" name="status" value="">
                         <input type="hidden" id="read" name="read" value="1">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Buat Surat Masuk') }}
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
