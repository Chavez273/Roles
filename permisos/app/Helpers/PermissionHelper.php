<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class PermissionHelper
{
    /**
     * Verifica si el usuario tiene el permiso dado (basado en la sesión).
     *
     * @param string $permissionName
     * @return bool
     */
    public static function check($permissionName)
    {
        $myPermissions = Session::get('user_permissions', []);

        // Dar pase libre al admi
        // $isAdmin = Session::get('is_admin', false);
        // if ($isAdmin) return true;

        return in_array($permissionName, $myPermissions);
    }
}
