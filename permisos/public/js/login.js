document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    // 1. Obtener datos del formulario
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const btn = document.getElementById('btn-login');
    const errorAlert = document.getElementById('error-alert');

    // --- CAMBIO 1: OBTENER EL TOKEN CSRF ---
    // Laravel necesita esto para saber que la petición es segura y crear la sesión.
    // Si no lo envías, recibirás un error 419.
    const csrfTokenTag = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenTag ? csrfTokenTag.getAttribute('content') : '';

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Entrando...';
    errorAlert.style.display = 'none';

    try {
        // --- CAMBIO 2: LA RUTA ES '/login' (No /api/login) ---
        // Al usar la ruta web, Laravel crea la cookie de sesión automáticamente.
        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken // --- CAMBIO 3: ENVIAR EL HEADER CSRF ---
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await response.json();

        if (response.ok) {
            // 3. ÉXITO: Guardar datos para el uso de JS (AJAX)

            // Token para futuras peticiones fetch('/api/...')
            localStorage.setItem('auth_token', data.access_token);

            // Datos visuales (Nombre, Avatar)
            localStorage.setItem('user_data', JSON.stringify(data.user));

            // Roles y Permisos (Para ocultar botones vía JS si fuera necesario)
            localStorage.setItem('user_roles', JSON.stringify(data.roles));
            localStorage.setItem('user_permissions', JSON.stringify(data.permissions));

            // Redirigir al dashboard
            // Ahora que hay cookie de sesión, el @can funcionará al cargar esta página
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

        // Limpiar contraseña
        document.getElementById('password').value = '';
    }
});

// Limpieza inicial
document.addEventListener('DOMContentLoaded', function() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_roles');
    localStorage.removeItem('user_permissions');
    localStorage.removeItem('user_data');
});
