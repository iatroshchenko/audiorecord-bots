<?php


namespace App\Services;


use App\Models\Role;

class RoleService
{
    public function getSuperadminRole(): Role
    {
        $role = Role::where('name', Role::SUPERADMIN_ROLE_NAME)
            ->first();

        if (!$role) {
            throw new \DomainException('Superadmin Role not found in database');
        }

        return $role;
    }
}
