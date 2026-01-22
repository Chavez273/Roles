@extends('layouts.app')

@section('title', 'Actividades | Operaciones')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Tablero de Actividades</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Actividades</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>15</h3>
                        <p>Nuevas Tareas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <a href="#" class="small-box-footer">Ver info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
                        <p>Eficiencia Operativa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="#" class="small-box-footer">Ver info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Usuarios Activos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">Ver info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>2</h3>
                        <p>Alertas Críticas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="#" class="small-box-footer">Ver info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">

            <section class="col-lg-7 connectedSortable">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Volumen de Operaciones
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Área</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header">
                        <h3 class="card-title">Chat de Operadores</h3>
                        <div class="card-tools">
                            <span title="3 New Messages" class="badge badge-primary">3</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="direct-chat-messages">
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">Juan Pérez</span>
                                    <span class="direct-chat-timestamp float-right">23 Ene 2:00 pm</span>
                                </div>
                                <img class="direct-chat-img" src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user1-128x128.jpg" alt="message user image">
                                <div class="direct-chat-text">
                                    ¿Alguien ha validado la carga de la Ruta 4?
                                </div>
                            </div>
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Admin</span>
                                    <span class="direct-chat-timestamp float-left">23 Ene 2:05 pm</span>
                                </div>
                                <img class="direct-chat-img" src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/img/user3-128x128.jpg" alt="message user image">
                                <div class="direct-chat-text">
                                    Sí, ya está en camino. Revisa el módulo de Viajes.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="message" placeholder="Escribir mensaje..." class="form-control">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary">Enviar</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            Lista de Tareas Pendientes
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="todo-list" data-widget="todo-list">
                            <li>
                                <span class="handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </span>
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo1" id="todoCheck1">
                                    <label for="todoCheck1"></label>
                                </div>
                                <span class="text">Revisar mantenimiento unidad #50</span>
                                <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                                <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                </div>
                            </li>
                            <li>
                                <span class="handle">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </span>
                                <div  class="icheck-primary d-inline ml-2">
                                    <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                                    <label for="todoCheck2"></label>
                                </div>
                                <span class="text">Validar reporte de combustible</span>
                                <small class="badge badge-info"><i class="far fa-clock"></i> 4 horas</small>
                                <div class="tools">
                                    <i class="fas fa-edit"></i>
                                    <i class="fas fa-trash-o"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer clearfix">
                        <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Añadir Tarea</button>
                    </div>
                </div>
            </section>

            <section class="col-lg-5 connectedSortable">

                <div class="card bg-gradient-primary">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            Cobertura de Flota
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="world-map" style="height: 250px; width: 100%; background-color: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                            <h4 class="text-white"><i class="fas fa-map"></i> Vista de Mapa Interactiva</h4>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="row">
                            <div class="col-4 text-center">
                                <div id="sparkline-1"></div>
                                <div class="text-white">Ruta Norte</div>
                            </div>
                            <div class="col-4 text-center">
                                <div id="sparkline-2"></div>
                                <div class="text-white">Ruta Centro</div>
                            </div>
                            <div class="col-4 text-center">
                                <div id="sparkline-3"></div>
                                <div class="text-white">Ruta Sur</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-gradient-success">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="far fa-calendar-alt"></i>
                            Calendario
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div style="height: 250px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <table class="table table-borderless text-white text-center">
                                <thead><tr><th>D</th><th>L</th><th>M</th><th>M</th><th>J</th><th>V</th><th>S</th></tr></thead>
                                <tbody>
                                    <tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td></tr>
                                    <tr><td>8</td><td>9</td><td>10</td><td class="bg-white text-success rounded">11</td><td>12</td><td>13</td><td>14</td></tr>
                                    <tr><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </section>
        </div>
        </div>
</section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    // Gráficos DEMO para que se vea bonito
    document.addEventListener("DOMContentLoaded", function() {
        // Area Chart (Revenue)
        var revenueChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
        var revenueChartData = {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
            datasets: [
                {
                    label: 'Viajes Completados',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    data: [28, 48, 40, 19, 86, 27, 90],
                    fill: true
                },
                {
                    label: 'Incidencias',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: true
                }
            ]
        }
        new Chart(revenueChartCanvas, {
            type: 'line',
            data: revenueChartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                elements: { line: { tension: 0.4 } } // Curvas suaves
            }
        });

        // Donut Chart (Sales)
        var salesChartCanvas = document.getElementById('sales-chart-canvas').getContext('2d');
        new Chart(salesChartCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Norte', 'Sur', 'Este'],
                datasets: [{
                    data: [30, 12, 20],
                    backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
            }
        });
    });
</script>
@endsection
