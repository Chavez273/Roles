@extends('layouts.app')

@section('title', 'Programación | Calendario')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Programación de Salidas</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Programar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3">
                <div class="sticky-top mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Viajes sin Asignar</h4>
                        </div>
                        <div class="card-body">
                            <div id="external-events">
                                <div class="external-event bg-success ui-draggable ui-draggable-handle" style="position: relative; cursor: move; margin-bottom: 10px; padding: 5px 10px; color: #fff;">
                                    Ruta Norte #102
                                </div>
                                <div class="external-event bg-warning ui-draggable ui-draggable-handle" style="position: relative; cursor: move; margin-bottom: 10px; padding: 5px 10px; color: #fff;">
                                    Carga Especial CDMX
                                </div>
                                <div class="external-event bg-info ui-draggable ui-draggable-handle" style="position: relative; cursor: move; margin-bottom: 10px; padding: 5px 10px; color: #fff;">
                                    Entrega Express
                                </div>
                                <div class="external-event bg-primary ui-draggable ui-draggable-handle" style="position: relative; cursor: move; margin-bottom: 10px; padding: 5px 10px; color: #fff;">
                                    Recolección Puerto
                                </div>
                                <div class="external-event bg-danger ui-draggable ui-draggable-handle" style="position: relative; cursor: move; margin-bottom: 10px; padding: 5px 10px; color: #fff;">
                                    Urgente: Cliente VIP
                                </div>
                                <div class="checkbox mt-3">
                                    <label for="drop-remove">
                                        <input type="checkbox" id="drop-remove">
                                        remover tras asignar
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Crear Evento Rápido</h3>
                        </div>
                        <div class="card-body">
                            <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                <ul class="fc-color-picker" id="color-chooser">
                                    <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                    <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                                </ul>
                            </div>
                            <div class="input-group">
                                <input id="new-event" type="text" class="form-control" placeholder="Título del viaje">
                                <div class="input-group-append">
                                    <button id="add-new-event" type="button" class="btn btn-primary">Añadir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-body p-0">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script> <script>
  $(function () {
    /* Inicializar eventos externos
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {
        var eventObject = {
          title: $.trim($(this).text()) // usar el texto del elemento como título
        }
        $(this).data('eventObject', eventObject)

        // Hacer arrastrables
        $(this).draggable({
          zIndex        : 1070,
          revert        : true,
          revertDuration: 0
        })
      })
    }

    ini_events($('#external-events div.external-event'))

    /* Inicializar el Calendario
     -----------------------------------------------------------------*/
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      themeSystem: 'bootstrap',
      //Eventos de Ejemplo (DEMO)
      events    : [
        {
          title          : 'Viaje #801 - Completado',
          start          : new Date(y, m, 1),
          backgroundColor: '#f56954',
          borderColor    : '#f56954',
          allDay         : true
        },
        {
          title          : 'Mantenimiento Unidad 4',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12',
          borderColor    : '#f39c12'
        },
        {
          title          : 'Ruta Sur (En curso)',
          start          : new Date(y, m, d, 10, 30),
          allDay         : false,
          backgroundColor: '#0073b7',
          borderColor    : '#0073b7'
        },
        {
          title          : 'Entrega Programada',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          backgroundColor: '#00a65a',
          borderColor    : '#00a65a'
        }
      ],
      editable  : true,
      droppable : true,
      drop      : function (date, allDay) {
        // Lógica al soltar un elemento en el calendario
        var originalEventObject = $(this).data('eventObject')
        var copiedEventObject = $.extend({}, originalEventObject)

        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        if ($('#drop-remove').is(':checked')) {
          $(this).remove()
        }
      }
    })

    /* Botón Añadir Evento */
    var currColor = '#3c8dbc' //Color por defecto
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      currColor = $(this).css('color')
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color'    : currColor
      })
    })

    $('#add-new-event').click(function (e) {
      e.preventDefault()
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.text(val)
      $('#external-events').prepend(event)

      ini_events(event)
      $('#new-event').val('')
    })
  })
</script>
<style>
    /* Ajustes visuales para el calendario */
    .fc-header-toolbar { padding-top: 10px; }
</style>
@endsection
