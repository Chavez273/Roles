const token = localStorage.getItem('auth_token');

document.addEventListener('DOMContentLoaded', function() {
    loadRoles();

    const roleForm = document.getElementById('roleForm');
    if(roleForm) roleForm.addEventListener('submit', saveRole);
});

async function loadRoles() {
    try {
        const response = await fetch('/api/roles', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
        }

        const roles = await response.json();
        const tbody = document.querySelector('#roles-table tbody');
        tbody.innerHTML = '';

        roles.forEach(role => {
            const tr = `
                <tr>
                    <td>${role.id}</td>
                    <td><strong>${role.name}</strong></td>
                    <td><span class="badge badge-secondary">${role.users_count || 0} usuarios</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="openModalEdit(${role.id})">
                            <i class="fas fa-key"></i> Editar Permisos
                        </button>
                        ${role.name !== 'Administrador' ?
                            `<button class="btn btn-sm btn-danger ml-1" onclick="deleteRole(${role.id})"><i class="fas fa-trash"></i></button>`
                            : ''}
                    </td>
                </tr>`;
            tbody.innerHTML += tr;
        });
    } catch (error) {
        console.error("Error cargando roles:", error);
    }
}

async function openModalCreate() {
    document.getElementById('roleForm').reset();
    document.getElementById('roleId').value = '';
    document.getElementById('roleName').value = '';
    document.getElementById('modalTitle').textContent = 'Crear Nuevo Rol';
    await loadPermissionsInModal('create');
    $('#roleModal').modal('show');
}

async function openModalEdit(id) {
    document.getElementById('roleId').value = id;
    document.getElementById('modalTitle').textContent = 'Editar Permisos del Rol';
    await loadPermissionsInModal(id);
    $('#roleModal').modal('show');
}

async function loadPermissionsInModal(roleIdOrMode) {
    const container = document.getElementById('permissions-container');
    container.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary"></div></div>';

    const url = roleIdOrMode === 'create' ? '/api/roles/create' : `/api/roles/${roleIdOrMode}`;

    try {
        const response = await fetch(url, {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const data = await response.json();

        if (data.role && roleIdOrMode !== 'create') {
            document.getElementById('roleName').value = data.role.name;
        }

        container.innerHTML = '';

        if (data.all_permissions) {
            data.all_permissions.forEach(p => {
                const currentPerms = data.role_permissions || [];
                const isChecked = currentPerms.includes(p.name) ? 'checked' : '';

                const html = `
                    <div class="col-md-6 mb-2">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input permission-check"
                                   id="perm_${p.id}" value="${p.name}" ${isChecked}>
                            <label class="custom-control-label" for="perm_${p.id}">
                                ${formatPermissionName(p.name)}
                            </label>
                        </div>
                    </div>`;
                container.innerHTML += html;
            });
        } else {
            container.innerHTML = '<p class="text-muted">No hay permisos disponibles.</p>';
        }

    } catch (error) {
        console.error("Error cargando permisos:", error);
        container.innerHTML = '<p class="text-danger">Error al cargar permisos. Revise la consola.</p>';
    }
}

function formatPermissionName(name) {
    return name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

async function saveRole(e) {
    e.preventDefault();

    const id = document.getElementById('roleId').value;
    const isEdit = id ? true : false;
    const url = isEdit ? `/api/roles/${id}` : '/api/roles';
    const method = isEdit ? 'PUT' : 'POST';

    const selectedPermissions = [];
    document.querySelectorAll('.permission-check:checked').forEach(cb => {
        selectedPermissions.push(cb.value);
    });

    const formData = {
        name: document.getElementById('roleName').value,
        permissions: selectedPermissions
    };

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(url, {
            method: method,
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (response.ok) {
            $('#roleModal').modal('hide');
            Swal.fire('Guardado', result.message, 'success');
            loadRoles();
        } else {
            Swal.fire('Error', result.message || 'Error al guardar', 'error');
        }
    } catch (error) { console.error(error); }
}

window.deleteRole = async function(id) {
    const res = await Swal.fire({
        title: '¿Eliminar Rol?',
        text: "Esto quitará los permisos a los usuarios asignados.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#d33'
    });

    if (res.isConfirmed) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/api/roles/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if(response.ok) {
                Swal.fire('Eliminado', '', 'success');
                loadRoles();
            } else {
                Swal.fire('Error', 'No se pudo eliminar', 'error');
            }
        } catch (error) { console.error(error); }
    }
}
