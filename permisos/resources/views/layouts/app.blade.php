<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Logístico')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css">

    <style>
        .permission-item { display: none; }
        .nav-sidebar .nav-item { transition: all 0.3s; }
        .custom-control-label { cursor: pointer; }
        .permission-card { border: 1px solid #ddd; padding: 10px; border-radius: 5px; margin-bottom: 10px; background: #fff; }
        .permission-card:hover { background: #f1f1f1; }
    </style>
</head>
<body class="hold-transition sidebar-mini">

<div id="loader" style="position:fixed; top:0; left:0; width:100%; height:100%; background:#f4f6f9; z-index:9999; display:flex; align-items:center; justify-content:center;">
    <div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div>
</div>

<div class="wrapper" id="main-wrapper" style="display:none;">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                    <span id="nav-username" class="ml-2">Usuario</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header" id="dropdown-role">Rol</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" id="logout-btn">
                        <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/dashboard" class="brand-link">
            <span class="brand-text font-weight-light">Logística APP</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block" id="sidebar-username">Cargando...</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Inicio</p>
                        </a>
                    </li>

                   @can('ver_seguridad')
                        <li class="nav-item permission-item" data-permission="ver_seguridad">
                            <a href="{{ route('permissions.control') }}" class="nav-link">
                                <i class="fas fa-user-shield nav-icon"></i><p> Permisos</p>
                            </a>
                        </li>
                    @endcan


                    @can('ver_usuarios')
                        <li class="nav-item">
                            <a href="{{ route('users.control') }}" class="nav-link">
                                <i class="fas fa-users nav-icon"></i><p> Usuarios</p>
                            </a>
                        </li>
                    @endcan

                    @can('ver_actividades')
                        <li class="nav-item">
                            <a href="{{ route('actividades.index') }}" class="nav-link">
                                <i class="fas fa-server nav-icon"></i><p> Actividades</p>
                            </a>
                        </li>
                    @endcan

                    @can('ver_finanzas')
                        <li class="nav-item">
                            <a href="{{ route('finanzas.index') }}" class="nav-link">
                                <i class="fas fa-bell nav-icon"></i><p> Egresos e ingresos</p>
                            </a>
                        </li>
                    @endcan


                    @can('solicitar_servicios')
                        <li class="nav-item">
                            <a href="{{ route('servicios.index') }}" class="nav-link">
                                <i class="fas fa-cash-register nav-icon"></i><p> Solicitar servicios</p>
                            </a>
                        </li>
                    @endcan


                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        @yield('content')
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>

<script src="{{ asset('js/layout.js') }}"></script>

@yield('scripts')

</body>
</html>
