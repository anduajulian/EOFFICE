@extends('layouts.app')


@section('content')
    

	<section class="content-header">
      <h1>
        Surat Masuk Terkirim
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
                    <th>Nomor</th>
                    <th>Kepada</th>
                    <th>Dari</th>
                    <th>Tanggal</th>
                    <th>Sifat</th>
                    <th>Lampiran</th>
                    <th>Softfile</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($surmas as $item)
                <tr class="item{{$item->id}}">
                    <td>{{$item->nomor}}</td>
                    <td>{{$item->kepada}}</td>
                    <td>{{$item->dari}}</td>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->sifat}}</td>

                    <td> <a href="{{ Storage::url("public$item->lampiran") }}">View</a></td> 
                    <!-- storage::url untuk membuka file -->
                    <td> <a href="{{ Storage::url("public$item->softfile") }}">View</a></td>
                    <!-- <td>{{$item->status}}</td> -->
                    <!-- untuk menerjemahkan status, seharusnya di controller -->
                    @if ($item->status == 1)
                        <td>Menunggu Konfirmasi</td>
                        @php
                            $status="Menunggu Konfirmasi";
                        @endphp
                    @elseif ($item->status == 2)
                        <td>Menunggu Disposisi</td>
                        @php
                            $status="Menunggu Disposisi";
                        @endphp
                    @elseif ($item->status == 3)
                        <td>Diarsipkan</td>
                        @php
                            $status="Diarsipkan";
                        @endphp
                    @else
                        <td>Ditolak</td>
                        @php
                            $status="Ditolak";
                        @endphp
                    @endif

                    <td>
                        <button class="edit-modal1 btn btn-info" 
                            data-info="{{$item->nomor}}*{{$item->kepada}}*{{$item->dari}}*{{$item->tanggal}}*{{$item->sifat}}*{{$item->lampiran}}*{{$item->hal}}*{{$item->softfile}}*{{$status}}*{{$item->created_at->diffForHumans()}}*{{$item->id}}">
                            <span class="glyphicon glyphicon-edit"></span>Detail
                        </button>
                        <button class="delete-modal1 btn btn-danger"
                            data-info="{{$item->id}}*{{$item->nomor}}*{{$item->hal}}">
                            <span class="glyphicon glyphicon-trash"></span>Delete
                        </button>
                        <!-- <button type="button" class="btn actionBtn btn-success edit" data-dismiss="modal">
                            <span id="footer_action_button" class="glyphicon glyphicon-check"> Update</span>
                        </button> -->
                    </td>
                </tr>
            @endforeach
            </tbody>
            <!-- <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </tfoot> -->
        </table>

    </section>
<!-- pop up modals -->
    <div id="myModal1" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <!-- id update diambil dari sini -->
                <span class="hidden uid1"></span>

                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nomor">Nomor</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="nomor" disabled>
                            </div>
                        </div>

                        <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="kepada">Kepada</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="kepada" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="dari">Dari</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="dari" disabled>
                            </div>
                        </div>
                        <p class="dari_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tanggal">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="tanggal" disabled>
                            </div>
                        </div>
                        <p class="tanggal_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sifat">Sifat</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="sifat" name="sifat" disabled>
                                    <option value="" disabled selected>Choose your option</option>
                                    <option value="rahasia">Rahasia</option>
                                    <option value="biasa">Biasa</option>
                                    <option value="sangat_segera">Sangat Segera</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="lampiran">Lampiran</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="lampiran" disabled>
                            </div>
                        </div>
                        <p class="lampiran_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hal">Hal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="hal" disabled>
                            </div>
                        </div>
                        <p class="hal_error error text-center alert alert-danger hidden"></p>

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
                            <label class="control-label col-sm-2" for="upload">Diupload</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="upload" disabled>
                            </div>
                        </div>
                        <p class="status_error error text-center alert alert-danger hidden"></p>
                    </form>

                    <div class="deleteContent">
                        Are you Sure you want to delete <span class="dname1"></span> ? 
                        <span class="hidden did1"></span> <!-- id untuk delete diambil dari sini -->
                    </div>
                    <div class="modal-footer1">
                        <button type="button" class="btn actionBtn" data-dismiss="modal">
                            <span id="footer_action_button" class='glyphicon'> </span>
                        </button>
                        <button type="button" class="btn actionBtn1" data-dismiss="modal">
                            <span id="footer_action_button1" class='glyphicon'> </span>
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