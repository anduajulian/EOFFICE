@extends('layouts.app')


@section('content')
    

	<section class="content-header">
      <h1>
        Arsip Disposisi
        <!-- <small>it all starts here</small> -->
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
         <!-- <table id="example" class="table table-striped table-bordered" style="width:100%"> -->
        

          <div class="card-body">
            @if( ! empty( ! empty( $success_msg = session( 'success' ) ) ) )
                <div class="alert alert-dismissible alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p>{{$success_msg}}</p>
                </div>
            @endif
            

          </div>

        <table class="table" id="table">
            <thead>
                <tr>
                    <th>Nomor Agenda/Registrasi</th>
                    <th>Tanggal Selesai</th>
                    <th>Dari</th>
                    <th>Disposisi</th>
                    <th>Diteruskan Kepada</th>
                    <th>Dibuat</th>
                    <th>Softfile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($disposisi as $item)
                <tr class="item{{$item->id}}">
                    <td>{{$item->nomor_agenda}}</td>
                    <td>{{$item->tgl_selesai}}</td>

                    @php
                        $dari = App\Http\Controllers\DisposisiController::descJabatan(Auth::user()->id);
                        $diteruskan = App\Http\Controllers\DisposisiController::descJabatan($item->diteruskan);
                    @endphp
                    <td>{{$dari}}</td>

                    <td>{{$item->disposisi}}</td>

                    <td>{{$diteruskan}}</td>

                    <td>{{$item->created_at->diffForHumans()}}</td>
                    
                    <td> <a href="{{ Storage::url("public$item->softfile") }}">View</a></td>

                    <td>
                        <button class="edit-modal2 btn btn-info" 
                            data-info="{{$item->nomor_agenda}}*{{$item->tgl_selesai}}*{{$dari}}*{{$item->isi}}*{{$item->catatan}}*{{$item->disposisi}}*{{$diteruskan}}*{{$item->paraf}}*{{$item->softfile}}*{{$item->status}}*{{$item->hardcopy}}*{{$item->id}}">
                            <span class="glyphicon glyphicon-edit"></span>Detail
                        </button>
                        <button class="delete-modal2 btn btn-danger"
                            data-info="{{$item->id}}*{{'Disposisi'}}*{{$dari}}">
                            <span class="glyphicon glyphicon-trash"></span>Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </section>
<!-- pop up modals -->
<div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <!-- id update diambil dari sini -->
                <span class="hidden uid2"></span>

                <div class="modal-body">
                    <form class="form-horizontal" role="form">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nomor_agenda">Nomor Agenda/Registrasi</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="nomor_agenda" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tgl_selesai">Tanggal Selesai</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="tgl_selesai" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="dari">Dari</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="dari" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="isi">Ringkasan Isi</label>
                            <div class="col-sm-10">
                                <!-- <input type="name" class="form-control" id="isi" disabled> -->
                                <textarea type="text" class="form-control" name="isi" id="isi" disabled></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="catatan">Catatan</label>
                            <div class="col-sm-10">
                                <!-- <input type="name" class="form-control" id="isi" disabled> -->
                                <textarea type="text" class="form-control" name="catatan" id="catatan" disabled></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="disposisi">Disposisi</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="disposisi" name="disposisi" disabled>
                                    <option value="" disabled selected>Choose your option</option>
                                    <option value="ditindaklanjuti">Ditindaklanjuti</option>
                                    <option value="wakili">Wakili</option>
                                    <option value="hadiri">Hadiri</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="diteruskan">Diteruskan</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="diteruskan" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="paraf">Paraf</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="paraf" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="softfile">Softfile</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="softfile" disabled>
                                <!-- <input type="file" class="form-control" id="softfile"> -->

                            </div>
                        </div>
                        <p class="softfile_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="status">Status</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="status" disabled>
                            </div>
                        </div>
                        <p class="status_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hardcopy">Letak Hardcopy</label>
                            <div class="col-md-10">
                                <select  name="hardcopy" class="form-control" id="hardcopy" disabled>
                                  <option disabled selected value> -- select an option -- </option>
                                  <option value="disimpan">Disimpan</option>
                                  <option value="tidak_diterima">Tidak Diterima</option>
                                  <option value="diterima">Diterima</option>
                                </select>
                            </div>
                        </div>
                        
                    </form>

                    <div class="deleteContent">
                        Are you Sure you want to delete <span class="dname2"></span> ? 
                        <span class="hidden did2"></span> <!-- id untuk delete diambil dari sini -->
                    </div>
                    <div class="modal-footer2">
                        <button type="button" class="btn actionBtn" data-dismiss="modal">
                            <span id="footer_action_button" class='glyphicon'> </span>
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection