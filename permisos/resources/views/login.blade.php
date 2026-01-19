<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de sesión | Sistema Logístico</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Sistema</b>Logístico</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Inicie sesión para comenzar</p>

            <div id="error-alert" class="alert alert-danger alert-dismissible" style="display:none;">
                <button type="button" class="close" onclick="document.getElementById('error-alert').style.display='none'">×</button>
                <span id="error-message">Error de credenciales</span>
            </div>

            <form id="loginForm">
                <div class="input-group mb-3">
                    <input type="text" id="email" class="form-control" placeholder="Email o Usuario" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">Recuérdame</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" id="btn-login" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mb-3 mt-3">
                <p>- O -</p>
                <a href="#" class="btn btn-block btn-primary mb-2">
                    <i class="fab fa-facebook mr-2"></i> Iniciar con Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google mr-2"></i> Iniciar con Gmail
                </a>
            </div>

            <p class="mb-1">
                <a href="#">Olvidé mi contraseña</a>
            </p>
            <p class="mb-0">
                <a href="/register" class="text-center">Registrar nueva cuenta</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>
