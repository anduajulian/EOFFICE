@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">Inbox Disposisi</h1>
                <!-- declare isi dari disposisi -->
                @foreach($dispos as $notnot)
                @endforeach


                    <form method="POST" action="{{ route('inbox.fwdDispos', $notnot->id) }}" aria-label="{{ __('Inbox Disposisi') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Nomor Agenda/Registrasi</label>   <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nomor_agenda') ? ' is-invalid' : '' }}" name="nomor_agenda" value="{{$notnot->nomor_agenda}}" disabled>

                               @if ($errors->has('nomor_agenda'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('nomor_agenda') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Tanggal Penyelesaian</label> 
                            <div class="col-md-6">
                               <input type="date" class="form-control{{ $errors->has('tgl_selesai') ? ' is-invalid' : '' }}" name="tgl_selesai" value="{{$notnot->tgl_selesai}}" disabled>

                               @if ($errors->has('tgl_selesai'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('tgl_selesai') }}</strong>
                                  </span>
                               @endif
                            </div>    
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Ringkasan Isi</label>
                            <div class="col-md-6">
                               <textarea type="text" class="form-control{{ $errors->has('isi') ? ' is-invalid' : '' }}" name="isi" value="{{$notnot->isi}}" disabled>{{$notnot->isi}}</textarea>

                               @if ($errors->has('isi'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('isi') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Catatan</label>
                            <div class="col-md-6">
                               <textarea type="text" class="form-control{{ $errors->has('catatan') ? ' is-invalid' : '' }}" name="catatan" value="{{$notnot->catatan}}" >{{$notnot->catatan}}</textarea>

                               @if ($errors->has('catatan'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('catatan') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Disposisi</label>
                            <div class="col-md-6">
                                <select  name="disposisi" class="form-control{{ $errors->has('disposisi') ? ' is-invalid' : '' }}" disabled>
                                  <option disabled @if(empty($notnot->disposisi)) selected @endif value> -- select an option -- </option>
                                  <option value="ditindaklanjuti" @if($notnot->disposisi == "ditindaklanjuti") selected @endif> Ditindaklanjuti </option>
                                  <option value="wakili" @if($notnot->disposisi == "wakili") selected @endif> Wakili </option>
                                  <option value="hadiri" @if($notnot->disposisi == "hadiri") selected @endif> Hadiri </option>
                                </select>

                                @if ($errors->has('disposisi'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('disposisi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Diteruskan Kepada</label>

                            <div class="col-md-6">
                                    @if(isset($listJabatan))
                                    <select class="form-control{{ $errors->has('diteruskan') ? ' is-invalid' : '' }}" name="diteruskan" >
                                        <option disabled selected value> -- select an option -- </option>
                                        @foreach($listJabatan as $listjabatan)
                                        <option value="{{$listjabatan->id}}" @if($notnot->diteruskan == $listjabatan->id) selected @endif>{{ $listjabatan->jabatan }}</option>
                                        @endforeach
                                     </select>
                                    @else
                                        <label >Database Kosyong</label>
                                    @endif  

                                @if ($errors->has('diteruskan'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('diteruskan') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" id="paraf" name="paraf" value="{{$notnot->paraf}}">

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Softfile</label>
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
                            <label class="col-md-4 col-form-label text-md-right">Letak Hardcopy</label>
                            <div class="col-md-6">
                                <select  name="hardcopy" class="form-control{{ $errors->has('hardcopy') ? ' is-invalid' : '' }}" required>
                                  <option disabled @if(empty($notnot->hardcopy)) selected @endif value> -- select an option -- </option>
                                  <option value="disimpan" @if($notnot->hardcopy == "disimpan") selected @endif> Disimpan </option>
                                  <option value="tidak_diterima" @if($notnot->hardcopy == "tidak_diterima") selected @endif> Tidak Diterima </option>
                                  <option value="diterima" @if($notnot->hardcopy == "diterima") selected @endif> Diterima </option>
                                </select>

                                @if ($errors->has('hardcopy'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hardcopy') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <input type="hidden" id="id_penerima" name="id_penerima" value="{{$notnot->id_penerima}}">
                         <input type="hidden" id="id_pembuat" name="id_pembuat" value="{{$notnot->id_pembuat}}">
                         <input type="hidden" id="id_surmas" name="id_surmas" value="{{$notnot->id_surmas}}">
                         <input type="hidden" id="status" name="status" value="{{$notnot->status}}">
                         <input type="hidden" id="read" name="read" value="{{$notnot->read}}">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Diteruskan') }}
                                </button>
                                <button type="submit" class="btn btn-success" formaction="{{ route('inbox.accDispos', $notnot->id) }}">
                                    {{ __('Ok') }}
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
