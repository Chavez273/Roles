const token = localStorage.getItem('auth_token');

document.addEventListener('DOMContentLoaded', function() {
    const storedRoles = JSON.parse(localStorage.getItem('user_roles') || '[]');

    if (!token || !storedRoles.includes('Administrador')) {
        window.location.href = '/dashboard';
        return;
    }

    const wrapper = document.getElementById('main-wrapper');
    if(wrapper) wrapper.style.display = 'block';

    loadUsers();
});

// 1. CARGAR USUARIOS
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
                    <td><span class="badge badge-secondary">${role}</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="openPermissionEditor(${user.id})">
                            <i class="fas fa-sliders-h"></i> Configurar Permisos
                        </button>
                    </td>
                </tr>`;
            tbody.innerHTML += tr;
        });

    } catch (error) { console.error('Error:', error); }
}

// 2. Cargar permisos del usuario
async function openPermissionEditor(userId) {
    try {
        // Pedir datos al servidor
        const response = await fetch(`/api/users/${userId}/permissions`, {
            headers: { 'Authorization': 'Bearer ' + token }
        });
        const data = await response.json();

        // Configurar Modal
        document.getElementById('modalUserId').value = userId;
        document.getElementById('modalUserName').textContent = data.user.name;

        const container = document.getElementById('permissionsContainer');
        container.innerHTML = '';

        // Generar Switches
        data.all_permissions.forEach(perm => {
            // Verificar si el usuario ya tiene este permiso
            const isChecked = data.user_permissions.includes(perm.name) ? 'checked' : '';

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

        $('#permissionModal').modal('show');

    } catch (error) { console.error(error); }
}

// 3. GUARDAR PERMISOS
async function savePermissions() {
    const userId = document.getElementById('modalUserId').value;

    // Recolectar todos los checkboxes marcados
    const checkedBoxes = document.querySelectorAll('.perm-checkbox:checked');
    const selectedPermissions = Array.from(checkedBoxes).map(cb => cb.value);

    try {
        const response = await fetch(`/api/users/${userId}/permissions`, {
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
            $('#permissionModal').modal('hide');
            Swal.fire('Actualizado', result.message, 'success');
        } else {
            Swal.fire('Error', 'No se pudieron guardar los cambios', 'error');
        }

    } catch (error) { console.error(error); }
}

function formatName(str) {
    return str.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}
