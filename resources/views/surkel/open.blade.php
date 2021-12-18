@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">Inbox Surat Keluar</h1>
                 <!-- declare isi dari surkel -->
                @foreach($surkel as $sur)
                @endforeach

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('inbox.rejSurkel', $sur->id) }}" aria-label="{{ __('Inobx Surat Keluar') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Nomor</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nomor') ? ' is-invalid' : '' }}" name="nomor" value="{{ $sur->nomor }}" disabled>

                               @if ($errors->has('nomor'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('nomor') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label  class="col-md-4 col-form-label text-md-right">Kepada</label>
                            <div class="col-md-6">
                              <input type="text" class="form-control{{ $errors->has('kepada') ? ' is-invalid' : '' }}" name="kepada" value="{{ $sur->kepada }}" disabled>
   

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
                                    @if(isset($listJabatan))
                                   <select class="form-control{{ $errors->has('dari') ? ' is-invalid' : '' }}" name="dari" disabled>
                                        
                                          <option disabled @if(empty($sur->dari)) selected @endif value> -- select an option -- </option>
                                          @foreach($listJabatan as $listjabatan)
                                            
                                            <option value="{{$listjabatan->id}}" @if($sur->dari == $listjabatan->id) selected @endif>{{ $listjabatan->jabatan }}</option>
                                            
                                          @endforeach
                                       </select>
                                    @else
                                        <label >Database Kosyong</label>
                                    @endif  

                                @if ($errors->has('dari'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dari') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- manggil fungsi di controller -->
                        @php
                          $multiTembusan = App\Http\Controllers\SuratKeluarController::multiTembusan($sur->tembusan);
                          $sumTembusan = count($multiTembusan);
                        @endphp

                        <div class="form-group row field_wrapper">
                          @if(isset($multiTembusan))

                            <label class="col-md-4 col-form-label text-md-right">Tembusan</label>
                            @for ($i=0; $i<$sumTembusan; $i++)
                              @if($i>0)
                             <div><label  class="col-md-4 col-form-label text-md-right"></label></div>
                              @endif
                            <div class="col-md-6">
                              <input type="text" class="form-control{{ $errors->has('tembusan[]') ? ' is-invalid' : '' }}" name="tembusan[]" value="{{ $multiTembusan[$i] }}" disabled>

                                @if ($errors->has('tembusan[]'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tembusan[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endfor

                          @else
                          <!-- jika tembusan null -->
                          <label  class="col-md-4 col-form-label text-md-right">Tembusan</label>
                              <div class="col-md-6">
                                    <input type="text" class="form-control{{ $errors->has('tembusan[]') ? ' is-invalid' : '' }}" name="tembusan[]" value="" disabled>


                                @if ($errors->has('tembusan[]'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tembusan[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif
                            
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Tanggal</label> 
                            <div class="col-md-6">
                               <input type="date" class="form-control{{ $errors->has('tanggal') ? ' is-invalid' : '' }}" name="tanggal" value="{{ $sur->tanggal }}" disabled>

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
                                  <option disabled @if(empty($sur->sifat)) selected @endif value> -- select an option -- </option>
                                  <option value="biasa" @if($sur->sifat == "biasa") selected @endif> Biasa </option>
                                  <option value="rahasia" @if($sur->sifat == "rahasia") selected @endif> Rahasia </option>
                                  <option value="sangat_segera" @if($sur->sifat == "sangat_segera") selected @endif> Sangat Segera </option>
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
                               @if(!empty($sur->lampiran))
                               <a href="{{ Storage::url($sur->lampiran) }}">View</a>
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
                               <input type="text" class="form-control{{ $errors->has('hal') ? ' is-invalid' : '' }}" name="hal" value="{{ $sur->hal }}" disabled>

                               @if ($errors->has('hal'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('hal') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Softfile</label>
                            <div class="col-md-6">
                               <input type="file" name="softfile" disabled>
                               @if(isset($sur->softfile))
                               <a href="{{ Storage::url($sur->softfile) }}">View</a>
                               @endif
                               @if ($errors->has('softfile'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('softfile') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Koreksi</label>
                            <div class="col-md-6">
                               <textarea type="text" class="form-control{{ $errors->has('koreksi') ? ' is-invalid' : '' }}" name="koreksi" value="{{ $sur->koreksi }}">{{ $sur->koreksi }}</textarea>

                               @if ($errors->has('koreksi'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('koreksi') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                         <input type="hidden" name="id_penerima" value="{{$sur->id_penerima}}">
                         <input type="hidden" id="id_pembuat" name="id_pembuat" value="{{$sur->id_pembuat}}">
                         <input type="hidden" id="status" name="status" value="{{$sur->id_status}}">
                         <input type="hidden" id="read" name="read" value="{{$sur->id_read}}">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Reject') }}
                                </button>
                                <button type="submit" class="btn btn-primary" formaction="{{ route('inbox.accSurkel', $sur->id) }}">
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
