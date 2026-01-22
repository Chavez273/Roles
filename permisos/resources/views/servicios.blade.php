@extends('layouts.app')

@section('title', 'Servicios | Catálogo')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Solicitud de Servicios Externos</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Servicios</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <h5 class="mb-2">Resumen de Solicitudes</h5>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-none">
                    <span class="info-box-icon bg-info"><i class="fas fa-tools"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mantenimiento</span>
                        <span class="info-box-number">5 Activos</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-success"><i class="fas fa-gas-pump"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Combustible</span>
                        <span class="info-box-number">12 Solicitudes</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow">
                    <span class="info-box-icon bg-warning"><i class="fas fa-truck-loading"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Carga/Descarga</span>
                        <span class="info-box-number">Regular</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box shadow-lg">
                    <span class="info-box-icon bg-danger"><i class="fas fa-phone-volume"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Emergencias</span>
                        <span class="info-box-number">0 Hoy</span>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="mt-4 mb-2">Proveedores Disponibles</h5>

        <div class="row">

            <div class="col-md-4">
                <div class="card card-widget widget-user-2 shadow-sm">
                    <div class="widget-user-header bg-warning">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user7-128x128.jpg" alt="User Avatar">
                        </div>
                        <h3 class="widget-user-username">Taller "El Rápido"</h3>
                        <h5 class="widget-user-desc">Mecánica General & Diesel</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Disponibilidad <span class="float-right badge bg-primary">Inmediata</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Ubicación <span class="float-right badge bg-info">Zona Norte</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Teléfono <span class="float-right badge bg-success">Solicitar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-widget widget-user shadow">
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">Grúas 24/7</h3>
                        <h5 class="widget-user-desc">Rescate Carretero</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user1-128x128.jpg" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">RESCATES</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">4.8</h5>
                                    <span class="description-text">RATING</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <button class="btn btn-sm btn-outline-info">Llamar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-widget widget-user-2 shadow-sm">
                    <div class="widget-user-header bg-success">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user8-128x128.jpg" alt="User Avatar">
                        </div>
                        <h3 class="widget-user-username">Limpieza Express</h3>
                        <h5 class="widget-user-desc">Lavado de Unidades</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Turno <span class="float-right badge bg-danger">Cerrado</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Costo Promedio <span class="float-right text-muted">$350 MXN</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Agendar <span class="float-right badge bg-secondary">Mañana</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card card-primary card-outline direct-chat direct-chat-primary shadow-none">
                    <div class="card-header">
                        <h3 class="card-title">Historial de Solicitud #9021</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="direct-chat-messages">
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">Operador</span>
                                    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                                </div>
                                <img class="direct-chat-img" src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user1-128x128.jpg" alt="Message User Image">
                                <div class="direct-chat-text">Necesito autorización para cambio de llanta en Ruta 5.</div>
                            </div>
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Supervisor</span>
                                    <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                                </div>
                                <img class="direct-chat-img" src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user3-128x128.jpg" alt="Message User Image">
                                <div class="direct-chat-text">Autorizado. Contacta a Gomera Central.</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="message" placeholder="Añadir nota..." class="form-control">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary">Guardar</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                 <div class="card bg-gradient-secondary">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-file-upload mr-1"></i>
                            Comprobantes de Servicios
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-secondary btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-5">
                            <i class="fas fa-cloud-upload-alt fa-3x"></i>
                            <p class="mt-2">Arrastre facturas o fotos del servicio aquí</p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="row">
                            <div class="col-4 text-center">
                                <div class="text-white">Facturas PDF</div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="text-white">Evidencia JPG</div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="text-white">Tickets</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
