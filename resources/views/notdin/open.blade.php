@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">Inbox Nota Dinas</h1>
                <!-- declare isi dari notadinas -->
                @foreach($notdin as $notnot)
                @endforeach
                    
                    <form method="POST" action="{{ route('inbox.rejNotdin', $notnot->id) }}" aria-label="{{ __('Inbox Nota Dinas') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Nomor</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nomor') ? ' is-invalid' : '' }}" name="nomor" value="{{$notnot->nomor}}"  disabled>

                               @if ($errors->has('nomor'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('nomor') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <!-- manggil fungsi kontroller-->
                        @php
                          $ddkepada = App\Http\Controllers\NotaDinasController::vDropdown($notnot->kepada);
                          $sumjabatan = count($ddkepada);
                        @endphp
                        <!-- <script>
                          $(function() {
                              $("#pft").val('3');
                          });
                        </script> -->

                        <div class="form-group row field_wrapper">
                          @if(isset($ddkepada))
                          <label  class="col-md-4 col-form-label text-md-right">Kepada</label>
                          @for ($i=0; $i<$sumjabatan; $i++)
                            @if($i>0)
                           <div><label  class="col-md-4 col-form-label text-md-right"></label></div>
                            @endif
                            
                            <div class="col-md-6">

                                 @if(isset($listJabatan))
                                 
                                    <select class="form-control{{ $errors->has('kepada[]') ? ' is-invalid' : '' }}" name="kepada[]" disabled>
                                          <option disabled selected value> -- select an option -- </option>
                                          <option value="6,10,14,18,22" @if($ddkepada[$i] == "semua") selected @endif>Semua Kepala Bidang</option>
                                        @foreach($listJabatan as $listjabatan)
                                          <option value="{{$listjabatan->id}}" @if($ddkepada[$i] == $listjabatan->id) selected @endif>{{ $listjabatan->jabatan }}</option>
                                            
                                        @endforeach
                                        
                                     </select>
                                  
                                  @else
                                        <label >Database Kosyong</label>
                                  @endif

                                @if ($errors->has('kepada[]'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kepada[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                              
                          @endfor  
                           <!-- jika kepada nya kosong -->
                            @else
                            <label  class="col-md-4 col-form-label text-md-right">Kepada</label>
                              <div class="col-md-6">
                                 @if(isset($listJabatan))
                                    <select class="form-control{{ $errors->has('kepada[]') ? ' is-invalid' : '' }}" name="kepada[]" disabled>
                                        <option disabled selected value> -- select an option -- </option>
                                        <option value="6,10,14,18,22">Semua Kepala Bidang</option>
                                        @foreach($listJabatan as $listjabatan)
                                            <option value="{{$listjabatan->id}}">{{ $listjabatan->jabatan }}</option>
                                        @endforeach
                                     </select>

                                    @else
                                        <label >Database Kosyong</label>
                                    @endif

                                @if ($errors->has('kepada[]'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kepada[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif
                        </div>


                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Dari</label>

                            <div class="col-md-6">
                                    @if(isset($listJabatan))
                                    <select class="form-control{{ $errors->has('dari') ? ' is-invalid' : '' }}" name="dari" disabled>
                                        
                                          <option disabled @if(empty($notnot->dari)) selected @endif value> -- select an option -- </option>
                                          @foreach($listJabatan as $listjabatan)
                                            
                                            <option value="{{$listjabatan->id}}" @if($notnot->dari == $listjabatan->id) selected @endif>{{ $listjabatan->jabatan }}</option>
                                            
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

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Tembusan</label>
                            <div class="col-md-6">
                                    @if(isset($listJabatan))
                                      <select class="form-control{{ $errors->has('tembusan') ? ' is-invalid' : '' }}" name="tembusan" disabled>
                                        
                                        <option disabled @if(empty($notnot->tembusan)) selected @endif value> -- select an option -- </option>
                                          @foreach($listJabatan as $listjabatan)
                                            <option value="{{$listjabatan->id}}" @if($notnot->tembusan == $listjabatan->id) selected @endif>{{ $listjabatan->jabatan }}</option>
                                          @endforeach
                                        
                                      </select>
                                    @else
                                        <label >Database Kosyong</label>
                                    @endif  

                                @if ($errors->has('tembusan'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tembusan') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Tanggal</label> 
                            <div class="col-md-6">
                               <input type="date" class="form-control{{ $errors->has('tanggal') ? ' is-invalid' : '' }}" name="tanggal" value="{{ $notnot->tanggal }}" disabled>

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

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Koreksi</label>
                            <div class="col-md-6">
                               <textarea type="text" class="form-control{{ $errors->has('koreksi') ? ' is-invalid' : '' }}" name="koreksi" value="{{ $notnot->koreksi }}">{{$notnot->koreksi}}</textarea>

                               @if ($errors->has('koreksi'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('koreksi') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                         <input type="hidden" name="id_penerima" value="{{$notnot->id_penerima}}">
                         <input type="hidden" id="id_pembuat" name="id_pembuat" value="{{$notnot->id_pembuat}}">
                         <input type="hidden" id="status" name="status" value="{{$notnot->status}}">
                         <input type="hidden" id="read" name="read" value="{{$notnot->read}}">

                      

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Reject') }}
                                </button>
                                <button type="submit" class="btn btn-primary" formaction="{{ route('inbox.accNotdin', $notnot->id) }}">
                                    {{ __('Approve') }}
                                </button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
