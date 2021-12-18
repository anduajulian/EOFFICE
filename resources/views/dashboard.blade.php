@extends('layouts.app')


@section('content')


    <section class="content-header">
      <h1>
        E-OFFICE
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box ">
            <div class="inner">
              <br>
              <br>
              <br>
              <br>
              <br>
              <br>
            </div>
            
           
          </div>
        </div>
        <!-- ./col -->
      </div>
@php
    $notdin = App\Http\Controllers\NotaDinasController::count();
    $surkel = App\Http\Controllers\SuratKeluarController::count();
    $surmas = App\Http\Controllers\SuratMasukController::count();
    $dispos = App\Http\Controllers\DisposisiController::count();
@endphp
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$notdin}}</h3>

              <p>Nota Dinas</p>
            </div>
            <div class="icon">
              <i class="ion ion-document-text"></i>
            </div>
            <a href="{{ route('notadinas.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$surkel}}</h3>

              <p>Surat Keluar</p>
            </div>
            <div class="icon">
              <i class="ion ion-arrow-up-a"></i>
            </div>
            <a href="{{ route('suratkeluar.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$surmas}}</h3>

              <p>Surat Masuk</p>
            </div>
            <div class="icon">
              <i class="ion ion-arrow-down-a"></i>
            </div>
            <a href="{{ route('suratmasuk.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$dispos}}</h3>

              <p>Disposisi</p>
            </div>
            <div class="icon">
              <i class="ion ion-clipboard"></i>
            </div>
            <a href="{{ route('disposisi.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

    </section>


@endsection