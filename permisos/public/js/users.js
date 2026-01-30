const token = localStorage.getItem('auth_token');
const myPermissions = JSON.parse(localStorage.getItem('user_permissions') || '[]');
let allUsers = [];

document.addEventListener('DOMContentLoaded', function() {
    // 1. Verificar permiso
    if (!token || !myPermissions.includes('ver_usuarios')) {
        window.location.href = '/dashboard';
        return;
    }

    // 2. Mostrar wrapper
    const wrapper = document.getElementById('main-wrapper');
    if(wrapper) wrapper.style.display = 'block';

    // 3. Botón crear
    const btnCreate = document.querySelector('button[onclick="openModalCreate()"]');
    if (btnCreate) {
        if (!myPermissions.includes('crear_usuario')) {
            btnCreate.style.display = 'none';
        } else {
            btnCreate.style.display = 'inline-block';
        }
    }

    // 4. Cargar usuarios
    loadUsers();

    // 5. Submit form
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', saveUser);
    }
});

// --- FUNCIONES LÓGICAS ---

async function loadUsers() {
    try {
        const response = await fetch('/api/users', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Error al cargar usuarios');

        const data = await response.json();
        allUsers = data.users;

        renderTable(data.users);

        if(data.roles) {
            renderRolesSelect(data.roles);
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire('Error', 'No se pudieron cargar los usuarios', 'error');
    }
}

function renderTable(users) {
    const tbody = document.querySelector('#users-table tbody');
    if(!tbody) return;

    tbody.innerHTML = '';

    users.forEach(user => {
        const role = user.roles && user.roles.length > 0 ? user.roles[0].name : 'Sin Rol';
        let buttonsHtml = '';

        if (myPermissions.includes('editar_usuario')) {
            buttonsHtml += `
                <button class="btn btn-sm btn-warning mr-1" onclick="openModalEdit(${user.id})">
                    <i class="fas fa-edit"></i>
                </button>`;
        }

        if (myPermissions.includes('eliminar_usuario')) {
            buttonsHtml += `
                <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">
                    <i class="fas fa-trash"></i>
                </button>`;
        }

        const tr = `
            <tr>
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td><span class="badge badge-info">${role}</span></td>
                <td>${buttonsHtml}</td>
            </tr>`;
        tbody.innerHTML += tr;
    });
}

function renderRolesSelect(roles) {
    const select = document.getElementById('userRole');
    if(!select) return;
    select.innerHTML = '<option value="">Seleccione...</option>';
    roles.forEach(r => {
        const roleName = (typeof r === 'object') ? r.name : r;
        select.innerHTML += `<option value="${roleName}">${roleName}</option>`;
    });
}

// --- FUNCIONES GLOBALES ---

window.openModalCreate = function() {
    const form = document.getElementById('userForm');
    if(form) form.reset();
    document.getElementById('userId').value = '';
    document.getElementById('modalTitle').textContent = 'Crear Nuevo Usuario';
    const passHelp = document.getElementById('passHelp');
    if(passHelp) passHelp.textContent = 'Obligatoria para nuevos usuarios.';
    $('#userModal').modal('show');
}

window.openModalEdit = function(id) {
    const user = allUsers.find(u => u.id == id);
    if (!user) return;

    document.getElementById('userId').value = user.id;
    document.getElementById('userName').value = user.name;
    document.getElementById('userPassword').value = '';

    const roleName = user.roles && user.roles.length > 0 ? user.roles[0].name : '';
    const roleSelect = document.getElementById('userRole');
    if(roleSelect) roleSelect.value = roleName;

    document.getElementById('modalTitle').textContent = 'Editar Usuario';
    const passHelp = document.getElementById('passHelp');
    if(passHelp) passHelp.textContent = 'Dejar vacío si no desea cambiarla.';
    $('#userModal').modal('show');
}

window.deleteUser = async function(id) {
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
            // --- CAMBIO: OBTENER TOKEN CSRF ---
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/api/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // <--- SE AGREGA EL HEADER
                }
            });

            if (response.ok) {
                Swal.fire('Eliminado!', 'El usuario ha sido eliminado.', 'success');
                loadUsers();
            } else {
                Swal.fire('Error', 'No se pudo eliminar el usuario', 'error');
            }
        } catch (error) { console.error(error); }
    }
}

// --- FUNCIÓN DE GUARDADO ---

async function saveUser(e) {
    e.preventDefault();

    const id = document.getElementById('userId').value;
    const isEdit = id ? true : false;
    const url = isEdit ? `/api/users/${id}` : '/api/users';
    const method = isEdit ? 'PUT' : 'POST';

    const formData = {
        name: document.getElementById('userName').value,
        role: document.getElementById('userRole').value,
    };

    const password = document.getElementById('userPassword').value;
    if (password) {
        formData.password = password;
    }

    try {
        // --- CAMBIO: OBTENER TOKEN CSRF ---
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(url, {
            method: method,
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken // <--- SE AGREGA EL HEADER
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (response.ok) {
            $('#userModal').modal('hide');
            Swal.fire('¡Éxito!', 'Operación realizada correctamente', 'success');
            loadUsers();
        } else {
            Swal.fire('Error', result.message || 'Error al guardar', 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
    }
}
