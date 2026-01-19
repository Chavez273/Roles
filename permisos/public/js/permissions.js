const token = localStorage.getItem('auth_token');

document.addEventListener('DOMContentLoaded', function() {
    const storedRoles = JSON.parse(localStorage.getItem('user_roles') || '[]');

    if (!token || !storedRoles.includes('Administrador')) {
        window.location.href = '/dashboard';
        return;
    }

    document.getElementById('main-wrapper').style.display = 'block';

    loadUsers();
});

// 1. CARGAR USUARIOS (Para ver quién tiene qué rol)
async function loadUsers() {
    try {
        const response = await fetch('/api/users', { headers: { 'Authorization': 'Bearer ' + token } });
        const data = await response.json();

        const tbody = document.querySelector('#users-table tbody');
        tbody.innerHTML = '';

        data.users.forEach(user => {
            const role = user.roles.length > 0 ? user.roles[0].name : 'Sin Rol';
            const tr = `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td><span class="badge badge-info">${role}</span></td>
                </tr>`;
            tbody.innerHTML += tr;
        });

    } catch (error) { console.error('Error:', error); }
}

// 2. ABRIR GESTOR DE ROLES
async function openRoleManager() {
    // 1. Cargar lista de roles en el select
    try {
        const response = await fetch('/api/roles', { headers: { 'Authorization': 'Bearer ' + token } });
        const roles = await response.json();

        const select = document.getElementById('roleSelect');
        select.innerHTML = '<option value="">-- Seleccione un Rol para editar --</option>';

        roles.forEach(role => {
            select.innerHTML += `<option value="${role.id}">${role.name}</option>`;
        });

        document.getElementById('permissionsContainer').innerHTML = '<p class="text-muted text-center col-12">Seleccione un rol arriba para ver sus permisos.</p>';

        $('#roleModal').modal('show');

    } catch (error) { console.error(error); }
}

// 3. CARGAR PERMISOS AL SELECCIONAR UN ROL
document.getElementById('roleSelect').addEventListener('change', async function() {
    const roleId = this.value;
    const container = document.getElementById('permissionsContainer');

    if (!roleId) {
        container.innerHTML = '<p class="text-muted text-center col-12">Seleccione un rol arriba para ver sus permisos.</p>';
        return;
    }

    container.innerHTML = '<div class="col-12 text-center"><i class="fas fa-spinner fa-spin"></i> Cargando permisos...</div>';

    try {
        const response = await fetch(`/api/roles/${roleId}`, { headers: { 'Authorization': 'Bearer ' + token } });
        const data = await response.json();

        container.innerHTML = '';

        // Generar Switches
        data.all_permissions.forEach(perm => {
            const isChecked = data.role_permissions.includes(perm.name) ? 'checked' : '';

            const html = `
                <div class="col-md-6 col-lg-4">
                    <div class="permission-card">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input perm-checkbox"
                                   id="perm_${perm.id}" value="${perm.name}" ${isChecked}>
                            <label class="custom-control-label" for="perm_${perm.id}">
                                ${formatName(perm.name)}
                            </label>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += html;
        });

    } catch (error) { console.error(error); }
});

// 4. GUARDAR CAMBIOS DEL ROL
async function saveRolePermissions() {
    const roleId = document.getElementById('roleSelect').value;

    if (!roleId) {
        Swal.fire('Atención', 'Por favor seleccione un rol primero', 'warning');
        return;
    }

    // Recolectar checkboxes marcados
    const checkedBoxes = document.querySelectorAll('.perm-checkbox:checked');
    const selectedPermissions = Array.from(checkedBoxes).map(cb => cb.value);

    try {
        const response = await fetch(`/api/roles/${roleId}`, {
            method: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ permissions: selectedPermissions })
        });

        const result = await response.json();

        if (response.ok) {
            Swal.fire('¡Actualizado!', result.message, 'success');
            //$('#roleModal').modal('hide'); //Para cerrar modal
        } else {
            Swal.fire('Error', 'No se pudieron guardar los cambios', 'error');
        }

    } catch (error) { console.error(error); }
}

function formatName(str) {
    return str.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}
