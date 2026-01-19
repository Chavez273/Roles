document.addEventListener('DOMContentLoaded', async function() {
    // 1. Verificar Autenticación básica
    const token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/';
        return;
    }

    // 2. Renderizado Rápido
    renderInterface();

    // 3. SINCRONIZACIÓN EN SEGUNDO PLANO
    await refreshUserPermissions(token);
});

// Función para pintar la pantalla
function renderInterface() {
    const storedUser = JSON.parse(localStorage.getItem('user_data') || '{}');
    const storedRoles = JSON.parse(localStorage.getItem('user_roles') || '[]');
    const storedPermissions = JSON.parse(localStorage.getItem('user_permissions') || '[]');

    // Nombre de Usuario
    if (storedUser.name) {
        const navUsername = document.getElementById('nav-username');
        const sidebarUsername = document.getElementById('sidebar-username');
        const contentUsername = document.getElementById('content-username');

        if(navUsername) navUsername.textContent = storedUser.name;
        if(sidebarUsername) sidebarUsername.textContent = storedUser.name;
        if(contentUsername) contentUsername.textContent = storedUser.name;
    }

    // Rol principal
    if (storedRoles.length > 0) {
        const dropdownRole = document.getElementById('dropdown-role');
        if(dropdownRole) dropdownRole.textContent = storedRoles[0];
    }

    // Mostrar/Ocultar según permisos
    const protectedElements = document.querySelectorAll('.permission-item');

    // CASO A: Administrador
    if (storedRoles.includes('Administrador')) {
        protectedElements.forEach(el => {
            el.style.display = 'block';
            if(el.tagName === 'LI') el.style.display = 'block';
        });

        const contentUserEl = document.getElementById('content-username');
        if(contentUserEl && !contentUserEl.textContent.includes('(Admin)')) {
            contentUserEl.textContent += " (Admin)";
        }
    }
    // CASO B: Usuario Normal
    else {
        protectedElements.forEach(el => {
            const requiredPermission = el.getAttribute('data-permission');
            el.style.display = 'none';

            if (storedPermissions.includes(requiredPermission)) {
                if (el.tagName === 'LI') {
                    el.style.display = 'block';
                } else {
                    el.style.display = 'block';
                }
            }
        });
    }

    // Mostrar wrapper final
    const loader = document.getElementById('loader');
    const mainWrapper = document.getElementById('main-wrapper');
    if(loader) loader.style.display = 'none';
    if(mainWrapper) mainWrapper.style.display = 'block';
}

// Función que consulta datos frescos a la API
async function refreshUserPermissions(token) {
    try {
        const response = await fetch('/api/user', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();

            localStorage.setItem('user_data', JSON.stringify(data.user));
            localStorage.setItem('user_roles', JSON.stringify(data.roles));
            localStorage.setItem('user_permissions', JSON.stringify(data.permissions));

            console.log("Permisos sincronizados con el servidor.");
            renderInterface();
        } else {
            // Si el token expiró o el usuario fue borrado
            if(response.status === 401) {
                localStorage.clear();
                window.location.href = '/';
            }
        }
    } catch (error) {
        console.error("Error sincronizando permisos:", error);
    }
}

const logoutBtn = document.getElementById('logout-btn');
if(logoutBtn) {
    logoutBtn.addEventListener('click', async function(e) {
        e.preventDefault();
        const token = localStorage.getItem('auth_token');
        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
        } catch (error) {}
        localStorage.clear();
        window.location.href = '/';
    });
}
