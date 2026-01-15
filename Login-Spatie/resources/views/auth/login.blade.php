<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center"><a href="#" class="h1"><b>Sistema</b>API</a></div>
    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger text-sm p-2">{{ $errors->first() }}</div>
      @endif
      <form action="{{ route('login.post') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="email" class="form-control" placeholder="Email/Usuario" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
      </form>
      <p class="mb-0 mt-2 text-center"><a href="{{ route('register') }}">Registrarme</a></p>
    </div>
  </div>
</div>
</body>
</html>
