@extends('layouts.app')

@section('content')
<!-- Include the jQuery library to use click event for add and remove buttons. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- The following JavaScript code handle adds remove input field functionality for Kepada. -->
<script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div><label  class="col-md-4 col-form-label text-md-right"></label><div class="col-md-6"><input type="text" class="form-control{{ $errors->has('tembusan[]') ? ' is-invalid' : '' }}" name="tembusan[]" value="{{ old('tembusan[]') }}" ></div><a href="javascript:void(0);" class="remove_button col-md-2">(-)</a></div>'; //New input field html 
            var x = 1; //Initial field counter is 1
            
            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){ 
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });
            
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header">Buat Surat Keluar</h1>

                <div class="card-body">
                    @if(count($errors) > 0)
                    <div class="alert alert-danger">
                      @foreach ($errors->all() as $error)
                      {{ $error }} <br/>
                      @endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('suratkeluar.store') }}" aria-label="{{ __('Buat Surat Keluar') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Nomor</label>     
                            <div class="col-md-6">
                               <input type="text" class="form-control{{ $errors->has('nomor') ? ' is-invalid' : '' }}" name="nomor" value="{{ old('nomor') }}" >

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
                                    @if(isset($listJabatan))
                                    <select class="form-control{{ $errors->has('dari') ? ' is-invalid' : '' }}" name="dari" required>
                                        <option disabled selected value> -- select an option -- </option>
                                        @foreach($listJabatan as $listjabatan)
                                            <option value="{{$listjabatan->id}}">{{ $listjabatan->jabatan }}</option>
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

                        <div class="form-group row field_wrapper">
                            <label class="col-md-4 col-form-label text-md-right">Tembusan</label>
                            <div class="col-md-6">
                              <input type="text" class="form-control{{ $errors->has('tembusan[]') ? ' is-invalid' : '' }}" name="tembusan[]" value="{{ old('tembusan[]') }}" >

                                @if ($errors->has('tembusan[]'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tembusan[]') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <a href="javascript:void(0);" class="add_button col-md-2" title="Add field">Tambah</a>
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

                        <div class="form-group row">
                           <label class="col-md-4 col-form-label text-md-right">Koreksi</label>
                            <div class="col-md-6">
                               <textarea type="text" class="form-control{{ $errors->has('koreksi') ? ' is-invalid' : '' }}" name="koreksi" value="{{ old('koreksi') }}"></textarea>

                               @if ($errors->has('koreksi'))
                                  <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('koreksi') }}</strong>
                                  </span>
                               @endif
                            </div>
                        </div>

                         <input type="hidden" name="id_penerima" value="">
                         <input type="hidden" id="id_pembuat" name="id_pembuat" value="{{ Auth::user()->id }}">
                         <input type="hidden" id="status" name="status" value="">
                         <input type="hidden" id="read" name="read" value="">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Buat Surat Keluar') }}
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
