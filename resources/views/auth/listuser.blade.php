@extends('layouts.app')


@section('content')
    

    <section class="content-header">
      <h1>
        List User Pegawai
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
                    <th>Id</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>alamat</th>
                    <th>Telepon</th>
                    <th>L/P</th>
                    <th>Terdaftar</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($peg as $item)
                <tr class="item{{$item->id}}">

                    <td>{{$item->id}}</td>
                    <td>{{$item->nip}}</td>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->alamat}}</td>
                    <td>{{$item->telepon}}</td>
                    <td>{{$item->jenis_kelamin}}</td>
                    <td>{{$item->created_at->diffForHumans()}}</td>

                    @php
                        $jabatan = App\Http\Controllers\EditShowPegawai::jabs($item->id_jabatan);
                    @endphp
                    <td>
                        <button class="edit-modal4 btn btn-info" 
                            data-info="{{$item->nip}}*{{$item->nama}}*{{$item->alamat}}*{{$item->telepon}}*{{$item->jenis_kelamin}}*{{$jabatan}}*{{$item->username}}*{{$item->email}}*{{$item->id}}">
                            <span class="glyphicon glyphicon-edit"></span>Detail
                        </button>
                        <button class="delete-modal4 btn btn-danger"
                            data-info="{{$item->id}}*{{$item->nip}}*{{$item->nama}}">
                            <span class="glyphicon glyphicon-trash"></span>Delete
                        </button>
                        <!-- <button type="button" class="btn actionBtn btn-success edit" data-dismiss="modal">
                            <span id="footer_action_button" class="glyphicon glyphicon-check"> Update</span>
                        </button> -->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </section>
<!-- pop up modals -->
    <div id="myModal4" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <!-- id update diambil dari sini -->
                <span class="hidden uid4"></span>

                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nip">NIP</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="nip" disabled>
                            </div>
                        </div>

                        <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="nama">Nama</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="nama" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="alamat">Alamat</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="alamat" disabled>
                            </div>
                        </div>
                        <p class="dari_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="telepon">Telepon</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="telepon" disabled>
                            </div>
                        </div>
                        <p class="tanggal_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="jenis_kelamin">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="sifat" name="jenis_kelamin" disabled>
                                    <option value="" disabled selected>Choose your option</option>
                                    <option value="pria">Pria</option>
                                    <option value="wanita">Wanita</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="jabatan">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="jabatan" disabled>
                            </div>
                        </div>
                        <p class="hal_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="username">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" disabled>
                            </div>
                        </div>
                        <p class="status_error error text-center alert alert-danger hidden"></p>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" disabled>
                            </div>
                        </div>
                        <p class="status_error error text-center alert alert-danger hidden"></p>
                    </form>

                    <div class="deleteContent">
                        Are you Sure you want to delete <span class="dname4"></span> ? 
                        <span class="hidden did4"></span> <!-- id untuk delete diambil dari sini -->
                    </div>
                    <div class="modal-footer4">
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