<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->nama }}</p>
          
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li>
          <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i><span>Dashboard</span>
          </a>
        </li>
        @php
            $unread = App\Http\Controllers\InboxController::unread();
        @endphp
        <li>
          <a href="{{ route('inbox.index') }}">
            <i class="fa fa-envelope-square"></i><span>Inbox</span>
            @if($unread == 0)
              <span class="label label-primary pull-right"></span>
            @else
              <span class="label label-primary pull-right">{{$unread}}</span>
            @endif
            
          </a>   
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i>
            <span>Nota Dinas</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('notadinas.create') }}"><i class="fa fa-circle-o"></i> Buat Baru </a></li>
            <li><a href="{{ route('notadinas.sent',Auth::user()->id) }}"><i class="fa fa-circle-o"></i> Terkirim </a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i>
            <span>Surat Masuk</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('suratmasuk.create') }}"><i class="fa fa-circle-o"></i> Buat Baru </a></li>
            <li><a href="{{ route('suratmasuk.show',Auth::user()->id) }}"><i class="fa fa-circle-o"></i> Terkirim </a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i>
            <span>Surat Keluar</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('suratkeluar.create') }}"><i class="fa fa-circle-o"></i> Buat Baru </a></li>
            <li><a href="{{ route('suratkeluar.show',Auth::user()->id) }}"><i class="fa fa-circle-o"></i> Terkirim </a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i>
            <span>Disposisi</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('disposisi.show',Auth::user()->id) }}"><i class="fa fa-circle-o"></i>Terkirim</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-archive"></i>
            <span>Arsip</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="{{ route('notadinas.index') }}"><i class="fa fa-circle-o"></i>Arsip Nota Dinas</a></li>
            <li><a href="{{ route('suratmasuk.index') }}"><i class="fa fa-circle-o"></i>Arsip Surat Masuk</a></li>
            <li><a href="{{ route('suratkeluar.index') }}"><i class="fa fa-circle-o"></i>Arsip Surat Keluar</a></li>
            <li><a href="{{ route('disposisi.index') }}"><i class="fa fa-circle-o"></i>Arsip Disposisi</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>User</span> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('user.listuser')}}"><i class="fa fa-circle-o"></i>List User</a></li>
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
