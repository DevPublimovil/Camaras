 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  
    <!-- Sidebar -->
    <div class="sidebar" >

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <a href="{{route('trafico.index')}}"><img src="{{asset('images/icono.png')}}" class="" alt="Publimovil"></a>
        </div>
        <div class="info">
          <a href="{{route('trafico.index')}}" class="d-block">GRUPO PUBLIMOVIL</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if(Auth::user()->status == 'activo')
          <li class="nav-item">
            <a href="{{route('clients.index')}}" class="nav-link" >
              <i class="nav-icon fa fa-desktop"></i>
              <p>
                MediaCam
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermission('list_clients') || Auth::user()->hasPermission('list_clients_ventas'))
          <li class="nav-item">
            <a href="@if(Auth::user()->hasPermission('list_clients_ventas')) {{route('ventas.index')}} @else {{route('trafico.index')}} @endif" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->hasPermission('view_graficos'))
          <li class="nav-item">
            <a href="{{route('vistas.index',['hoy',1])}}" class="nav-link">
              <i class="nav-icon fa fa-line-chart" aria-hidden="true"></i>
              <p>
                Graficos
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{route('mediacam.profile')}}" class="nav-link">
              <i class="nav-icon fa fa-user-circle"></i>
              <p>
                Mi cuenta
              </p>
            </a>
          </li>
          {{-- @if(Auth::user()->hasPermission('pantallas.index')) --}}
          <li class="nav-item">
            <a href="{{route('mediacam.contacts')}}" class="nav-link">
              <i class="nav-icon fa fa-commenting" aria-hidden="true"></i>
              <p>
                Contactos
              </p>
            </a>
          </li>
          {{-- @endif --}}

          <li class="nav-item">
                <div class="row justify-content-center mt-2 user-panel" style="border-bottom:none">
                    <div class="col-2 info">
                        <a href="https://www.facebook.com/publimovilregional/" target="_blank"><i class="fa fa-facebook-official fa-2x text-white" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-2 info">
                        <a href="https://www.instagram.com/grupo_publimovil/?hl=es-la" target="_blank"><i class="fa fa-instagram fa-2x text-white" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-2 info">
                        <a href="http://www.grupopublimovil.com" target="_blank"><i class="fa fa-globe fa-2x" style="color:#FF3C00" aria-hidden="true"></i></a>
                    </div>
                </div>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>