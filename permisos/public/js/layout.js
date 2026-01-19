document.addEventListener('DOMContentLoaded', async function() {
    const token = localStorage.getItem('auth_token');

    // Validación de sesión
    if (!token && window.location.pathname !== '/' && window.location.pathname !== '/register') {
        window.location.href = '/';
        return;
    }

    // Renderizar Menú
    renderLayout();

    // Logout
    const logoutBtn = document.getElementById('logout-btn');
    if(logoutBtn) {
        logoutBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                });
            } catch (error) {}
            localStorage.clear();
            window.location.href = '/';
        });
    }
});

function renderLayout() {
    const storedUser = JSON.parse(localStorage.getItem('user_data') || '{}');
    const storedRoles = JSON.parse(localStorage.getItem('user_roles') || '[]');
    const storedPermissions = JSON.parse(localStorage.getItem('user_permissions') || '[]');

    // Nombres
    if (storedUser.name) {
        const nav = document.getElementById('nav-username');
        const side = document.getElementById('sidebar-username');
        if(nav) nav.textContent = storedUser.name;
        if(side) side.textContent = storedUser.name;
    }

    // Rol en Navbar
    if (storedRoles.length > 0) {
        const drop = document.getElementById('dropdown-role');
        if(drop) drop.textContent = storedRoles[0];
    }

    // Mostrar items del Sidebar según permisos
    const protectedElements = document.querySelectorAll('.permission-item');
    if (storedRoles.includes('Administrador')) {
        protectedElements.forEach(el => el.style.display = 'block');
    } else {
        protectedElements.forEach(el => {
            const req = el.getAttribute('data-permission');
            if (storedPermissions.includes(req)) el.style.display = 'block';
        });
    }

    // Mostrar interfaz final
    const loader = document.getElementById('loader');
    const wrapper = document.getElementById('main-wrapper');
    if(loader) loader.style.display = 'none';
    if(wrapper) wrapper.style.display = 'block';
}
