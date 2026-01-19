document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    // 1. Obtener datos
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const btn = document.getElementById('btn-login');
    const errorAlert = document.getElementById('error-alert');

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Entrando...';
    errorAlert.style.display = 'none';

    try {
        // 2. Petición a la API
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await response.json();

        if (response.ok) {
            // 3. ÉXITO: Guardar TODO en LocalStorage

            // Token de acceso para futuras peticiones
            localStorage.setItem('auth_token', data.access_token);

            // Datos del usuario para mostrar nombre/avatar
            localStorage.setItem('user_data', JSON.stringify(data.user));

            // Roles y Permisos para controlar qué botones se ven en el Dashboard
            localStorage.setItem('user_roles', JSON.stringify(data.roles));
            localStorage.setItem('user_permissions', JSON.stringify(data.permissions));

            // Redirigir al dashboard
            window.location.href = '/dashboard';
        } else {
            // 4. ERROR
            throw new Error(data.message || 'Error al iniciar sesión');
        }

    } catch (error) {
        console.error(error);
        document.getElementById('error-message').textContent = error.message;
        errorAlert.style.display = 'block';

        btn.disabled = false;
        btn.textContent = 'Ingresar';

        // Limpiar contraseña por seguridad
        document.getElementById('password').value = '';
    }
});
document.addEventListener('DOMContentLoaded', function() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_roles');
    localStorage.removeItem('user_permissions');
    localStorage.removeItem('user_data');
});
