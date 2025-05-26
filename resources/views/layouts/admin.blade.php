{{-- <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TecRoom</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!--Style datatable -->
    <link rel="stylesheet" type="text/css" href="{{asset('https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css')}}"/>



    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
  

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>TR</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>TecRoom</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
     

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
                    
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>

            <li class="treeview">
              <a href="/">
                <i class="fa fa-home"></i>
                <span>Inicio</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>Usuarios</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              
            </li>
            <li class="treeview">
              <a href="hoteles/huesped">
                <i class="fa fa-user-plus"></i>
                <span>Añadir huesped</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              
            </li>
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>Hoteles</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="hoteles/categorias"><i class="fa fa-circle-o"></i> Categorias</a></li>
              </ul>
              <ul class="treeview-menu">
                <li><a href="hoteles/hotel"><i class="fa fa-circle-o"></i> Hoteles</a></li>
              </ul>
 
            </li>
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bed"></i>
                <span>Habitaciones</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="compras/ingreso"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                <li><a href="compras/proveedor"><i class="fa fa-circle-o"></i> Proveedores</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder-open"></i>
                <span>Servicios</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="servicios/bar"><i class="fa fa-circle-o"></i> Bar</a></li>
                <li><a href="servicios/piscina"><i class="fa fa-circle-o"></i> Piscina</a></li>
                <li><a href="servicios/restaurant"><i class="fa fa-circle-o"></i> Restaurante</a></li>

              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-line-chart"></i>
                <span>Reservaciones</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="compras/ingreso"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                <li><a href="compras/proveedor"><i class="fa fa-circle-o"></i> Proveedores</a></li>
              </ul>
            </li>
                       
            <li class="treeview">
              <a href="compras/ingreso">
                <i class="fa fa-sign-out"></i> <span>Cerrar Sesion</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              
            </li>       
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de Reservas</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  	<div class="row">
	                  	<div class="col-md-12">
		                          <!--Contenido-->
                              @yield('contenido')
		                          <!--Fin Contenido-->
                           </div>
                        </div>
		                    
                  		</div>
                  	</div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2019-2023 <a href="www.incanatoit.com">IncanatoIT</a>.</strong> All rights reserved.
      </footer>

      
    <!-- jQuery 2.1.4 -->
    <!-- JQuery 3.6.1 -->
    <script src="{{asset('js/jquery-3.6.1.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>
    <!-- Js for dataetables -->
    <script src="{{asset('js/datatable.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js')}}"></script>
  </body>
</html>
 --}}