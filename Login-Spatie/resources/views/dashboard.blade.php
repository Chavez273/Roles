@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Bienvenido, {{ $user['name'] }}</h1>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card card-primary card-outline">
            <div class="card-header"><h5 class="m-0">Estado de Conexión</h5></div>
            <div class="card-body">
                <p>Estás conectado vía API. Tus datos:</p>
                <ul>
                    <li>ID: {{ $user['id'] }}</li>
                    <li>Email: {{ $user['email'] }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
