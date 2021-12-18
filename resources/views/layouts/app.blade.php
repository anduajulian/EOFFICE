<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-OFFICE | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/_all-skins.min.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/morris.js/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/jvectormap/jquery-jvectormap.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @section('css')
    @show
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      @include('layouts.header')


      @include('layouts.sidebar')

      <div class="content-wrapper">
          @yield('content')
      </div>

    @include('layouts.footer')
    </div>
    <!-- ./wrapper -->
   
    <!-- jQuery 3 -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
          $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <!-- disni yang bikin pop up logouy -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- ini solusinya -->
    <script>

        (function($){

            $(document).ready(function (){
                    $('.dropdown-toggle').dropdown();
                    $('#data').dropdown('toggle');
            });

        })(jQuery);
    </script>
    <!-- Morris.js charts -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/raphael/raphael.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/bower_components/morris.js/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script type="text/javascript" src="{{asset('adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/moment/min/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- datepicker -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script type="text/javascript" src="{{asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script type="text/javascript" src="{{asset('adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script type="text/javascript" src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script type="text/javascript" src="{{asset('adminlte/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script type="text/javascript" src="{{asset('adminlte/dist/js/demo.js')}}"></script>
    
    <!-- Include the jQuery library to use click event for add and remove buttons. -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
        function isNumber(event){
            var keycode=event.keyCode;
            if(keycode>=48 && keycode<=57){
                return true;
            }
            return false;
        }
    </script>
    <!-- The following JavaScript code handle adds remove input field functionality for Lampiran. -->
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button2'); //Add button selector
            var wrapper = $('.field_wrapper2'); //Input field wrapper
            var fieldHTML = '<div><label class="col-md-4 col-form-label text-md-right"></label><div class="col-md-6"><input type="file" name="lampiran[]" value="" ><br></div><a href="javascript:void(0);" class="remove_button2 col-md-2">(-)</a></div>'; //New input field html 
            var y = 1; //Initial field counter is 1
            
            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(y < maxField){ 
                    y++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });
            
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button2', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                y--; //Decrement field counter
            });
        });
    </script>

    <style type="text/css">
        .offset-md-4 {
            margin-left: 64.33333333%;

        }
    </style>

    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <!-- ini yang bikin ga bisa pop up -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 


    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        } );
    </script>

<!-- oprek disini mau ganti apa yang muncul di pop up -->
<!-- untuk notdin -->
<script>
    
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Edit");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('View');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        //dsni
        var stuff = $(this).data('info').split('*'); //kalo ada yang null jadi ga work        
        $('.uid').text(stuff[10]);
        fillmodalData(stuff);// harus diubah sebelum kesini, mungkin buat function
        
        $('#myModal').modal('show');
    });

    //agar ada popup nya
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split('*');
        $('.did').text(stuff[0]);
        $('.dname').html(stuff[1] +" "+stuff[2]);
        $('#myModal').modal('show');
    });

    function fillmodalData(details){
        // tanda pagar melemparkan value ke field yang sama "id" nya
        $('#kepada').val(details[0]);
        $('#dari').val(details[1]);
        $('#tembusan').val(details[2]);
        $('#tanggal').val(details[3]);
        $('#nomor').val(details[4]);
        $('#sifat').val(details[5]);
        $('#lampiran').val(details[6]);
        $('#hal').val(details[7]);
        $('#softfile').val(details[8]);
        $('#status').val(details[9]);
    }
    
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deleteNotdin',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
            },
            //fungsi ajax yg ini yg akan ngefek jika diklik (untuk ngoprek direct ke route button update di modal)
            success: function(data) {
                $('.item' + $('.did').text()).remove();
            }
        });
    });

    $('.modal-footer').on('click', '.edit', function() {
        //UPDATE: Dibuat post aja, ke route baru, dari route nanti redirect ke notadinas.show dengan request->id || ga work bngst
        //update: ngoper data dari view ke sini hiyahiyahiya
        //sukses alhamdulillah
        $.ajax({
            type: 'get',
            url: '/showNotdin',
            data: {
                'id': $('.uid').text()
            },
            success: function(data){
                // if(response == '1') // response berisikan data di controller
                
                // window.location.href = '{{ route('notadinas.edit',  5) }}';
                window.location.href = '/notadinas/' + data + '/edit'; //pacak pacak uhuyy alhamdulillah
                
            }
        });
    });
  
</script>

<!--        untuk surmas      ----------------------------------- -->
<script>
    
    $(document).on('click', '.edit-modal1', function() {
        $('#footer_action_button').text("Edit");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');

        $('#footer_action_button1').show();
        $('.actionBtn1').show();
        $('#footer_action_button1').text("Disposisi");
        $('#footer_action_button1').addClass('glyphicon-check');
        $('.actionBtn1').addClass('btn-success');
        $('.actionBtn1').addClass('dispos');

        $('.modal-title').text('Deatil Surat Masuk');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        //dsni
        var stuff = $(this).data('info').split('*'); //kalo ada yang null jadi ga work        
        $('.uid1').text(stuff[10]); //set uid dengan id di array ke 10
        fillmodalData1(stuff);// harus diubah sebelum kesini, mungkin buat function
        
        $('#myModal1').modal('show');
    });

    //agar ada popup nya
    $(document).on('click', '.delete-modal1', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('#footer_action_button1').hide();
        $('.actionBtn1').hide();
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split('*');
        $('.did1').text(stuff[0]);
        $('.dname1').html(stuff[1] +" "+stuff[2]);
        $('#myModal1').modal('show');
    });

    function fillmodalData1(details){
        // tanda pagar melemparkan value ke field yang sama "id" nya
        $('#nomor').val(details[0]);
        $('#kepada').val(details[1]);
        $('#dari').val(details[2]);
        $('#tanggal').val(details[3]);
        $('#sifat').val(details[4]);
        $('#lampiran').val(details[5]);
        $('#hal').val(details[6]);
        $('#softfile').val(details[7]);
        $('#status').val(details[8]);
        $('#upload').val(details[9]);
    }
    
    $('.modal-footer1').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deleteSurmas',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did1').text()
            },
            //fungsi ajax yg ini yg akan ngefek jika diklik (untuk ngoprek direct ke route button update di modal)
            success: function(data) {
                $('.item' + $('.did1').text()).remove();
            }
        });
    });

    $('.modal-footer1').on('click', '.edit', function() {
        //UPDATE: Dibuat post aja, ke route baru, dari route nanti redirect ke notadinas.show dengan request->id || ga work bngst
        //update: ngoper data dari view ke sini hiyahiyahiya
        //sukses alhamdulillah
        $.ajax({
            type: 'get',
            url: '/showSurmas',
            data: {
                'id': $('.uid1').text()
            },
            success: function(data){
                // if(response == '1') // response berisikan data di controller
                
                // window.location.href = '{{ route('notadinas.edit',  5) }}';
                window.location.href = '/suratmasuk/' + data + '/edit'; //pacak pacak uhuyy alhamdulillah
                
            }
        });
    });

    $('.modal-footer1').on('click', '.dispos', function() {
        //UPDATE: Dibuat post aja, ke route baru, dari route nanti redirect ke notadinas.show dengan request->id || ga work bngst
        //update: ngoper data dari view ke sini hiyahiyahiya
        //sukses alhamdulillah
        $.ajax({
            type: 'get',
            url: '/disposisi/create',
            data: {
                'id': $('.uid1').text()
            },
            success: function(data){
                // if(response == '1') // response berisikan data di controller
                
                // window.location.href = '{{ route('notadinas.edit',  5) }}';
                window.location.href = '/disposisi/create/surmas=' + data; //pacak pacak uhuyy alhamdulillah
                
            }
        });
    });
  
</script>


<!-- untuk disposisi -->
<script>
    
    $(document).on('click', '.edit-modal2', function() {
        $('#footer_action_button').text(" Edit");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('View');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        //dsni
        var stuff = $(this).data('info').split('*'); //kalo ada yang null jadi ga work        
        $('.uid2').text(stuff[11]);
        fillmodalData2(stuff);// harus diubah sebelum kesini, mungkin buat function
        
        $('#myModal2').modal('show');
    });

    //agar ada popup nya
    $(document).on('click', '.delete-modal2', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split('*');
        $('.did2').text(stuff[0]);
        $('.dname2').html(stuff[1] +" "+stuff[2]);
        $('#myModal2').modal('show');
    });

    function fillmodalData2(details){
        // tanda pagar melemparkan value ke field yang sama "id" nya
        $('#nomor_agenda').val(details[0]);
        $('#tgl_selesai').val(details[1]);
        $('#dari').val(details[2]);
        $('#isi').val(details[3]);
        $('#catatan').val(details[4]);
        $('#disposisi').val(details[5]);
        $('#diteruskan').val(details[6]);
        $('#paraf').val(details[7]);
        $('#softfile').val(details[8]);
        $('#status').val(details[9]);
        $('#hardcopy').val(details[10]);
    }
    
    $('.modal-footer2').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deleteDisposisi',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did2').text()
            },
            //fungsi ajax yg ini yg akan ngefek jika diklik (untuk ngoprek direct ke route button update di modal)
            success: function(data) {
                $('.item' + $('.did2').text()).remove();
            }
        });
    });

    $('.modal-footer2').on('click', '.edit', function() {
        //UPDATE: Dibuat post aja, ke route baru, dari route nanti redirect ke notadinas.show dengan request->id || ga work bngst
        //update: ngoper data dari view ke sini hiyahiyahiya
        //sukses alhamdulillah
        $.ajax({
            type: 'get',
            url: '/showDisposisi',
            data: {
                'id': $('.uid2').text()
            },
            success: function(data){
                // if(response == '1') // response berisikan data di controller
                
                // window.location.href = '{{ route('notadinas.edit',  5) }}';
                window.location.href = '/disposisi/' + data + '/edit'; //pacak pacak uhuyy alhamdulillah
                
            }
        });
    });
  
</script>

<!-- untuk surat keluar -->
<script>
    
    $(document).on('click', '.edit-modal3', function() {
        $('#footer_action_button').text(" Edit");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('View');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        //dsni
        var stuff = $(this).data('info').split('*'); //kalo ada yang null jadi ga work        
        $('.uid3').text(stuff[10]);
        fillmodalData3(stuff);// harus diubah sebelum kesini, mungkin buat function
        
        $('#myModal3').modal('show');
    });

    //agar ada popup nya
    $(document).on('click', '.delete-modal3', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split('*');
        $('.did3').text(stuff[0]);
        $('.dname3').html(stuff[1] +" "+stuff[2]);
        $('#myModal3').modal('show');
    });

    function fillmodalData3(details){
        // tanda pagar melemparkan value ke field yang sama "id" nya
        $('#nomor').val(details[0]);
        $('#kepada').val(details[1]);
        $('#dari').val(details[2]);
        $('#tembusan').val(details[3]);
        $('#tanggal').val(details[4]);
        $('#sifat').val(details[5]);
        $('#lampiran').val(details[6]);
        $('#hal').val(details[7]);
        $('#softfile').val(details[8]);
        $('#status').val(details[9]);
    }
    
    $('.modal-footer3').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deleteSurkel',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did3').text()
            },
            //fungsi ajax yg ini yg akan ngefek jika diklik (untuk ngoprek direct ke route button update di modal)
            success: function(data) {
                $('.item' + $('.did3').text()).remove();
            }
        });
    });

    $('.modal-footer3').on('click', '.edit', function() {
        //UPDATE: Dibuat post aja, ke route baru, dari route nanti redirect ke notadinas.show dengan request->id || ga work bngst
        //update: ngoper data dari view ke sini hiyahiyahiya
        //sukses alhamdulillah
        $.ajax({
            type: 'get',
            url: '/showSurkel',
            data: {
                'id': $('.uid3').text()
            },
            success: function(data){
                // if(response == '1') // response berisikan data di controller
                
                // window.location.href = '{{ route('notadinas.edit',  5) }}';
                window.location.href = '/suratkeluar/' + data + '/edit'; //pacak pacak uhuyy alhamdulillah
                
            }
        });
    });
  
</script>
<!-- untuk user/pegawai -->
<script>
    
    $(document).on('click', '.edit-modal4', function() {
        $('#footer_action_button').text(" Edit");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('View');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        //dsni
        var stuff = $(this).data('info').split('*'); //kalo ada yang null jadi ga work        
        $('.uid4').text(stuff[8]);
        fillmodalData4(stuff);// harus diubah sebelum kesini, mungkin buat function
        
        $('#myModal4').modal('show');
    });

    //agar ada popup nya
    $(document).on('click', '.delete-modal4', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split('*');
        $('.did4').text(stuff[0]);
        $('.dname4').html(stuff[1] +" "+stuff[2]);
        $('#myModal4').modal('show');
    });

    function fillmodalData4(details){
        // tanda pagar melemparkan value ke field yang sama "id" nya
        $('#nip').val(details[0]);
        $('#nama').val(details[1]);
        $('#alamat').val(details[2]);
        $('#telepon').val(details[3]);
        $('#jenis_kelamin').val(details[4]);
        $('#jabatan').val(details[5]);
        $('#username').val(details[6]);
        $('#email').val(details[7]);
    }
    
    $('.modal-footer4').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deleteUser',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did4').text()
            },
            //fungsi ajax yg ini yg akan ngefek jika diklik (untuk ngoprek direct ke route button update di modal)
            success: function(data) {
                $('.item' + $('.did4').text()).remove();
            }
        });
    });

    $('.modal-footer4').on('click', '.edit', function() {
       
        $.ajax({
            type: 'get',
            url: '/showUser',
            data: {
                'id': $('.uid4').text()
            },
            success: function(data){
                window.location.href = '/user/' + data + '/edit';    
            }
        });
    });
  
</script>
     @section('js')
     
     @show
</body>
</html>
