@extends('layouts.app')
@section('title', 'Gestión de Roles')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Roles y Permisos</h1></div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary btn-lg" onclick="openRoleManager()"><i class="fas fa-cogs"></i> Configurar Roles</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Usuarios y sus Roles</h3></div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="users-table">
                        <thead><tr><th>ID</th><th>Usuario</th><th>Rol</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Configurar Roles</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="form-group">
                        <label>1. Seleccione Rol:</label>
                        <select id="roleSelect" class="form-control form-control-lg"></select>
                    </div>
                    <hr>
                    <label>2. Permisos:</label>
                    <div class="p-3 border rounded bg-white">
                        <div class="row" id="permissionsContainer">
                            <p class="text-muted text-center col-12">Seleccione un rol...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="saveRolePermissions()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/permissions.js') }}"></script>
@endsection
