const token = localStorage.getItem('auth_token');

document.addEventListener('DOMContentLoaded', function() {
    // Seguridad Frontend: Verificar si es Administrador
    const storedRoles = JSON.parse(localStorage.getItem('user_roles') || '[]');

    if (!token || !storedRoles.includes('Administrador')) {
        window.location.href = '/dashboard';
        return;
    }

    // Mostrar la interfaz si pasa la validación
    const wrapper = document.getElementById('main-wrapper');
    if(wrapper) wrapper.style.display = 'block';

    loadUsers();
});

// 1. CARGAR USUARIOS
async function loadUsers() {
    try {
        const response = await fetch('/api/users', { headers: { 'Authorization': 'Bearer ' + token } });
        const data = await response.json();
        renderTable(data.users);
        renderRolesSelect(data.roles);
    } catch (error) { console.error('Error:', error); }
}

function renderTable(users) {
    const tbody = document.querySelector('#users-table tbody');
    tbody.innerHTML = '';

    users.forEach(user => {
        const role = user.roles.length > 0 ? user.roles[0].name : 'Sin Rol';
        const tr = `
            <tr>
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td><span class="badge badge-info">${role}</span></td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick='openModalEdit(${JSON.stringify(user)})'>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
        tbody.innerHTML += tr;
    });
}

function renderRolesSelect(roles) {
    const select = document.getElementById('userRole');
    select.innerHTML = '<option value="">Seleccione...</option>';
    roles.forEach(r => select.innerHTML += `<option value="${r}">${r}</option>`);
}

// 2. MODALES
function openModalCreate() {
    document.getElementById('userForm').reset();
    document.getElementById('userId').value = '';
    document.getElementById('modalTitle').textContent = 'Crear Nuevo Usuario';
    document.getElementById('passHelp').textContent = 'Obligatoria para nuevos usuarios.';
    $('#userModal').modal('show');
}

function openModalEdit(user) {
    document.getElementById('userId').value = user.id;
    document.getElementById('userName').value = user.name;
    document.getElementById('userPassword').value = '';

    const role = user.roles.length > 0 ? user.roles[0].name : '';
    document.getElementById('userRole').value = role;

    document.getElementById('modalTitle').textContent = 'Editar Usuario';
    document.getElementById('passHelp').textContent = 'Dejar vacío si no desea cambiarla.';
    $('#userModal').modal('show');
}

// 3. GUARDAR (Crear o Editar)
document.getElementById('userForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const id = document.getElementById('userId').value;
    const isEdit = id ? true : false;
    const url = isEdit ? `/api/users/${id}` : '/api/users';
    const method = isEdit ? 'PUT' : 'POST';
    const formData = {
        name: document.getElementById('userName').value,
        role: document.getElementById('userRole').value,
        password: document.getElementById('userPassword').value
    };

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (response.ok) {
            $('#userModal').modal('hide');
            Swal.fire('¡Éxito!', result.message, 'success');
            loadUsers();
        } else {
            Swal.fire('Error', result.message || 'Error al guardar', 'error');
        }
    } catch (error) { console.error(error); }
});

// 4. ELIMINAR
async function deleteUser(id) {
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`/api/users/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': 'Bearer ' + token }
            });
            const data = await response.json();
            if (response.ok) {
                Swal.fire('Eliminado!', data.message, 'success');
                loadUsers();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } catch (error) { console.error(error); }
    }
}
