@extends('layouts.app')


@section('content')

    <section class="content-header">
      <h1>
        Kotak Masuk
        <!-- <small>it all starts here</small> -->
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
         <!-- <table id="example" class="table table-striped table-bordered" style="width:100%"> -->

        <table class="table" id="table">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Dari</th>
                    <th>Sifat</th>
                    <th>Perihal</th>
                    <th>Status</th>                    
                    <th>Dibuat</th>
                    <th>Softfile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($surmas as $item)
            @if($item->read == 1)
                <tr class="item{{$item->id}}" bgcolor="lightblue">
            @else
                <tr class="item{{$item->id}}">
            @endif
                
                    <td>Surat Masuk</td>
                    <td>{{$item->nomor}}</td>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->dari}}</td>
                    <td>{{$item->sifat}}</td>
                    <td>{{$item->hal}}</td>

                    <!-- untuk menerjemahkan status -->
                    @if ($item->status == 2)
                        <td>Menunggu Konfirmasi Pimpinan</td>
                    @elseif ($item->status == 3)
                        <td>Menunggu Konfirmasi Bagian Umum</td>
                    @elseif ($item->status == 4)
                        <td>Diarsipkan</td>
                    @else
                        <td>Menunggu Disposisi</td>
                    @endif

                    <td>{{$item->created_at->diffForHumans()}}</td>
                
                    <td> <a href="{{ Storage::url("public$item->softfile") }}">View</a></td> 
                    
                    <td>
                        <form method="GET" action="{{ route('inbox.openSurmas', $item->id) }}">
                        <button type="submit" class="btn btn-info">
                            <span  class="glyphicon glyphicon-edit"></span>Open
                        </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @foreach($surkel as $item1)
            @if($item1->read == 1)
                <tr class="item1{{$item1->id}}" bgcolor="lightblue">
            @else
                <tr class="item1{{$item1->id}}">
            @endif
                
                    <td>Surat Keluar</td>
                    <td>{{$item1->nomor}}</td>
                    <td>{{$item1->tanggal}}</td>
                    <td>{{$item1->dari}}</td>
                    <td>{{$item1->sifat}}</td>
                    <td>{{$item1->hal}}</td>

                    <!-- untuk menerjemahkan status -->
                    @if ($item1->status == 2)
                        <td>Menunggu Konfirmasi Pimpinan</td>
                    @elseif ($item1->status == 3)
                        <td>Menunggu Konfirmasi TU</td>
                    @elseif ($item1->status == 4)
                        <td>Diarsipkan</td>
                    @elseif ($item1->status == 5)
                        <td>Ditolak</td>
                    @else
                        <td>Menunggu Konfirmasi Bidang Umum</td>
                    @endif

                    <td>{{$item1->created_at->diffForHumans()}}</td>
                
                    <td> <a href="{{ Storage::url("public$item1->softfile") }}">View</a></td> 
                    
                    <td>
                        <form method="GET" action="{{ route('inbox.openSurkel', $item1->id) }}">
                        <button type="submit" class="btn btn-info">
                            <span  class="glyphicon glyphicon-edit"></span>Open
                        </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @foreach($notdin as $item2)
            @php
                $read = App\Http\Controllers\NotaDinasController::read($item2->id);
            @endphp
            @if($read[0] == 1)
                <tr class="item2{{$item2->id}}" bgcolor="lightblue">
            @else
                <tr class="item2{{$item2->id}}">
            @endif
                
                    <td>Nota Dinas</td>
                    <td>{{$item2->nomor}}</td>
                    <td>{{$item2->tanggal}}</td>

                    @php
                        $dari = App\Http\Controllers\NotaDinasController::disJabatan($item2->dari);
                    @endphp

                    <td>{{$dari}}</td>
                    <td>{{$item2->sifat}}</td>
                    <td>{{$item2->hal}}</td>

                    <!-- untuk menerjemahkan status -->
                    @if ($item2->status == 2)
                        <td>Menunggu Konfirmasi TU</td>
                    @elseif ($item2->status == 3)
                        <td>Sudah Dipublikasikan</td>
                    @elseif ($item2->status == 1)
                        <td>Menunggu Konfirmasi Pimpinan</td>
                    @else
                        <td>Ditolak</td>
                    @endif

                    <td>{{$item2->created_at->diffForHumans()}}</td>
                
                    <td> <a href="{{ Storage::url("public$item2->softfile") }}">View</a></td> 
                    
                    <td>
                        <form method="GET" action="{{ route('inbox.openNotdin', $item2->id) }}">
                        <button type="submit" class="btn btn-info">
                            <span  class="glyphicon glyphicon-edit"></span>Open
                        </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @foreach($disposisi as $item3)
            @if($item3->read == 1)
                <tr class="item3{{$item3->id}}" bgcolor="lightblue">
            @else
                <tr class="item3{{$item3->id}}">
            @endif
                
                    <td>Disposisi</td>
                    <td>{{$item3->nomor_agenda}}</td>
                    <td>{{$item3->tanggal}}</td>
                    <td>{{$item3->dari}}</td>
                    <td>{{$item3->sifat}}</td>
                    <td>{{$item3->catan}}</td>

                    <!-- untuk menerjemahkan status -->
                    @if ($item3->status == 2)
                        <td>Ditindaklanjuti</td>
                    @elseif ($item3->status == 3)
                        <td>Dihadiri</td>
                    @else
                        <td>Menunggu Respon</td>
                    @endif

                    <td>{{$item3->created_at->diffForHumans()}}</td>
                
                    <td> <a href="{{ Storage::url("public$item3->softfile") }}">View</a></td> 
                    
                    <td>
                        <form method="GET" action="{{ route('inbox.openDisposisi', $item3->id) }}">
                        <button type="submit" class="btn btn-info">
                            <span  class="glyphicon glyphicon-edit"></span>Open
                        </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </section>

    
@endsection