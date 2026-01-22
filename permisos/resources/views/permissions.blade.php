@extends('layouts.app')

@section('title', 'Gestión de Roles y Permisos')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Roles del Sistema</h1></div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary" onclick="openModalCreate()">
                        <i class="fas fa-plus-circle"></i> Nuevo Rol
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="roles-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Rol</th>
                                <th>Usuarios Asignados</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"> <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalTitle">Configurar Rol</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="roleForm">
                    <div class="modal-body">
                        <input type="hidden" id="roleId">

                        <div class="form-group">
                            <label>Nombre del Rol</label>
                            <input type="text" class="form-control" id="roleName" required placeholder="Ej. Supervisor">
                        </div>

                        <hr>
                        <label>Asignar Permisos</label>
                        <p class="text-muted small">Seleccione los permisos que tendrá este rol.</p>

                        <div class="row" id="permissions-container">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/permissions.js') }}"></script>
@endsection
