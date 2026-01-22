@extends('layouts.app')

@section('title', 'Dashboard | Sistema Logístico')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Bienvenido, <span id="content-username">Usuario</span></h1>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">
                    Panel Principal del Sistema.
                </div>
            </div>

            <div class="text-center my-3 permission-item" data-permission="crear_tarea">
                <a href="#" style="background-color: #0055ff; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; width: 250px;">
                    Añadir Tarea
                </a>
            </div>

            <div class="text-center my-3 permission-item" data-permission="solicitar_viaje">
                <a href="#" style="background-color: #28a745; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; width: 250px;">
                    Solicitar viaje
                </a>
            </div>

            <div class="text-center my-3 permission-item" data-permission="programar_viaje">
                <a href="{{ route('viajes.programar') }}" style="background-color: #17a2b8; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; width: 250px;">
                    Programar viaje
                </a>
            </div>

            <div class="text-center my-3 permission-item" data-permission="ver_usuarios">
                <a href="{{ route('users.control') }}" style="background-color: #dc3545; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; width: 250px;">
                    Control usuarios
                </a>
            </div>

            <div class="text-center my-3 permission-item" data-permission="ver_seguridad">
                 <a href="{{ route('permissions.control') }}" style="background-color: #ffc107; color: #000; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; width: 250px;">
                    Gestión Permisos
                </a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<script>
    const u = JSON.parse(localStorage.getItem('user_data') || '{}');
    document.getElementById('content-username').textContent = u.name || 'Usuario';
</script>
@endsection
