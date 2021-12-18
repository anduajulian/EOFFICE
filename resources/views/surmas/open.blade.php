@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">Inbox Surat Masuk</h1>
                <!-- declare isi dari suratmasuk -->
                @foreach($surmas as $notnot)
                @endforeach


                    <form method="GET" action="{{ route('inbox.accSurmas', $notnot->id) }}" aria-label="{{ __('Inbox Surat Masuk') }}" enctype="multipart/form-data">
                        @csrf
                        

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Nomor</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nomor') ? ' is-invalid' : '' }}" name="nomor" value="{{$notnot->nomor}}" disabled >

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
                               <input type="text" class="form-control{{ $errors->has('kepada') ? ' is-invalid' : '' }}" name="kepada" value="{{$notnot->kepada}}" disabled>

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
                               <input type="text" class="form-control{{ $errors->has('dari') ? ' is-invalid' : '' }}" name="dari" value="{{$notnot->dari}}" disabled>

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
                               <input type="date" class="form-control{{ $errors->has('tanggal') ? ' is-invalid' : '' }}" name="tanggal" value="{{$notnot->tanggal}}" disabled>

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
                                <select  name="sifat" class="form-control{{ $errors->has('sifat') ? ' is-invalid' : '' }}" disabled>
                                  <option disabled @if(empty($notnot->sifat)) selected @endif value> -- select an option -- </option>
                                  <option value="biasa" @if($notnot->sifat == "biasa") selected @endif> Biasa </option>
                                  <option value="rahasia" @if($notnot->sifat == "rahasia") selected @endif> Rahasia </option>
                                  <option value="sangat_segera" @if($notnot->sifat == "sangat_segera") selected @endif> Sangat Segera </option>
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
                               <input type="file" name="lampiran" disabled>
                               @if(!empty($notnot->lampiran))
                               <a href="{{ Storage::url($notnot->lampiran) }}">View</a>
                               @endif

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
                               <input type="text" class="form-control{{ $errors->has('hal') ? ' is-invalid' : '' }}" name="hal" value="{{ $notnot->hal }}" disabled>

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
                               <input type="file" name="softfile" disabled>
                               @if(isset($notnot->softfile))
                                  <a href="{{ Storage::url($notnot->softfile) }}">View</a>
                               @endif

                               @if ($errors->has('softfile'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('softfile') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                         <input type="hidden" name="id_penerima" value="{{ $notnot->id_penerima }}">
                         <input type="hidden" id="id_pembuat" name="id_pembuat" value="{{ $notnot->id_pembuat }}">
                         <input type="hidden" id="status" name="status" value="{{ $notnot->status }}">
                         <input type="hidden" id="read" name="read" value="{{ $notnot->read }}">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                              <!-- jika ditekan button maka akan route? kalo ada reject?  bisa make formaction yeay -->
                                <button type="submit" class="btn btn-success" formaction="{{ route('disposisi.buat', $notnot->id) }}">
                                    {{ __('Disposisi') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Approve') }}
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
