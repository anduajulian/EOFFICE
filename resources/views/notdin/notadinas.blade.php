@extends('layouts.app')


@section('content')
<section class="content-header">
      <h1>
        Arsip Nota Dinas
        <!-- <small>it all starts here</small> -->
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">

      
          <h4 class="box-title">Nota Dinas</h4>

          <div class="card-body">
	        @if( ! empty( ! empty( $success_msg = session( 'success' ) ) ) )
	        	<div class="alert alert-dismissible alert-success">
		            <button type="button" class="close" data-dismiss="alert">&times;</button>
		            <p>{{$success_msg}}</p>
	        	</div>
			@endif
          	

          </div>

    </section>
@endsection