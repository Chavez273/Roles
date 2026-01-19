@extends('layouts.app')
@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Gestión de Usuarios</h1></div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary" onclick="openModalCreate()"><i class="fas fa-plus"></i> Nuevo</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="users-table">
                        <thead><tr><th>ID</th><th>Nombre</th><th>Rol</th><th>Acciones</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalTitle">Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="userForm">
                    <div class="modal-body">
                        <input type="hidden" id="userId">
                        <div class="form-group"><label>Nombre</label><input type="text" class="form-control" id="userName" required></div>
                        <div class="form-group"><label>Rol</label><select class="form-control" id="userRole" required></select></div>
                        <div class="form-group"><label>Password</label><input type="password" class="form-control" id="userPassword"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/users.js') }}"></script>
@endsection
