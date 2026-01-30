document.addEventListener('DOMContentLoaded', async function() {
    const token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.href = '/';
        return;
    }


    renderUserInfo();

    document.getElementById('loader').style.display = 'none';
    document.getElementById('main-wrapper').style.display = 'block';

    await refreshUserData(token);
});

function renderUserInfo() {
    const storedUser = JSON.parse(localStorage.getItem('user_data') || '{}');
    const storedRoles = JSON.parse(localStorage.getItem('user_roles') || '[]');

    if (storedUser.name) {
        const navUsername = document.getElementById('nav-username');
        const sidebarUsername = document.getElementById('sidebar-username');
        const contentUsername = document.getElementById('content-username');

        if(navUsername) navUsername.textContent = storedUser.name;
        if(sidebarUsername) sidebarUsername.textContent = storedUser.name;
        if(contentUsername) contentUsername.textContent = storedUser.name;
    }

    if (storedRoles.length > 0) {
        const dropdownRole = document.getElementById('dropdown-role');
        if(dropdownRole) dropdownRole.textContent = storedRoles[0];
    }
}

async function refreshUserData(token) {
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

            renderUserInfo();
        } else {
            if(response.status === 401) {
                localStorage.clear();
                window.location.href = '/';
            }
        }
    } catch (error) {
        console.error("Error sincronizando sesión:", error);
    }
}

const logoutBtn = document.getElementById('logout-btn');
if(logoutBtn) {
    logoutBtn.addEventListener('click', async function(e) {
        e.preventDefault();

        const csrfTokenTag = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenTag ? csrfTokenTag.getAttribute('content') : '';
        const token = localStorage.getItem('auth_token');

        try {
            await fetch('/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        } catch (error) { console.error(error); }

        localStorage.clear();
        window.location.href = '/';
    });
}
