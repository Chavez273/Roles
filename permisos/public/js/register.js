document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Obtener elementos
    const btn = document.getElementById('btn-register');
    const errorAlert = document.getElementById('error-alert');

    // Preparar datos
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value,
        terms: document.getElementById('agreeTerms').checked
    };

    // UI Loading (Feedback visual)
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
    errorAlert.style.display = 'none';

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            // EXITO: Guardar datos igual que en el Login
            // Esto es crucial para que el usuario entre directo al dashboard con permisos
            localStorage.setItem('auth_token', data.access_token);
            localStorage.setItem('user_data', JSON.stringify(data.user));
            localStorage.setItem('user_roles', JSON.stringify(data.roles)); // Guardamos el rol (Cliente)
            localStorage.setItem('user_permissions', JSON.stringify(data.permissions)); // Guardamos permisos

            // Redirigir al dashboard ya logueado
            window.location.href = '/dashboard';
        } else {
            // Manejo de errores de validación de Laravel
            let errorMsg = data.message || 'Error en el registro';

            if (data.errors) {

                errorMsg = Object.values(data.errors).flat()[0];
            }

            throw new Error(errorMsg);
        }

    } catch (error) {
        document.getElementById('error-message').textContent = error.message;
        errorAlert.style.display = 'block';
        btn.disabled = false;
        btn.textContent = 'Registrar';
    }
});
