const token = localStorage.getItem('auth_token');
const myPermissions = JSON.parse(localStorage.getItem('user_permissions') || '[]');
let allUsers = []; // Variable global para guardar los usuarios cargados

document.addEventListener('DOMContentLoaded', function() {
    // 1. Verificar si tiene permiso de ver la pantalla
    if (!token || !myPermissions.includes('ver_usuarios')) {
        window.location.href = '/dashboard';
        return;
    }

    // 2. Mostrar el contenedor principal
    const wrapper = document.getElementById('main-wrapper');
    if(wrapper) wrapper.style.display = 'block';

    // 3. Ocultar botón de "Nuevo Usuario" si no tiene permiso
    // Buscamos el botón por su atributo onclick
    const btnCreate = document.querySelector('button[onclick="openModalCreate()"]');
    if (btnCreate) {
        if (!myPermissions.includes('crear_usuario')) {
            btnCreate.style.display = 'none';
        } else {
            btnCreate.style.display = 'inline-block';
        }
    }

    // 4. Cargar la tabla de usuarios
    loadUsers();

    // 5. Configurar el evento Submit del formulario (si existe)
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
        allUsers = data.users; // Guardamos en global para usarlo al editar

        renderTable(data.users);

        // Si tu API devuelve roles, llenamos el select
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

        // Construimos los botones según los permisos
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

    // Limpiamos y dejamos la opción por defecto
    select.innerHTML = '<option value="">Seleccione...</option>';

    // Verificamos si roles es un array de strings o de objetos
    roles.forEach(r => {
        // Ajusta esto según cómo venga tu API (r.name o r directamente)
        const roleName = (typeof r === 'object') ? r.name : r;
        select.innerHTML += `<option value="${roleName}">${roleName}</option>`;
    });
}

// --- FUNCIONES GLOBALES (Para que funcionen desde el HTML onclick) ---

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
    // Buscamos el usuario en la variable global
    const user = allUsers.find(u => u.id == id);
    if (!user) return;

    document.getElementById('userId').value = user.id;
    document.getElementById('userName').value = user.name;
    document.getElementById('userPassword').value = ''; // Contraseña vacía al editar

    // Seleccionar rol
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
            const response = await fetch(`/api/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
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

// --- FUNCIÓN DE GUARDADO (Interna) ---

async function saveUser(e) {
    e.preventDefault();

    const id = document.getElementById('userId').value;
    const isEdit = id ? true : false;
    const url = isEdit ? `/api/users/${id}` : '/api/users';
    const method = isEdit ? 'PUT' : 'POST';

    // Construimos el objeto a enviar
    const formData = {
        name: document.getElementById('userName').value,
        role: document.getElementById('userRole').value,
    };

    // Solo agregamos password si se escribió algo
    const password = document.getElementById('userPassword').value;
    if (password) {
        formData.password = password;
    }

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
            Swal.fire('¡Éxito!', 'Operación realizada correctamente', 'success');
            loadUsers();
        } else {
            // Mostramos error del backend
            Swal.fire('Error', result.message || 'Error al guardar', 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Ocurrió un error inesperado', 'error');
    }
}
