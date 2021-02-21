<?php


namespace App\Services;


use App\Models\Role;
use App\Models\User;

class AdminService
{
    public function getSuperadmin(): ?User
    {
        return User::with([
            'role' => function ($query) {
                $query->where('name', Role::SUPERADMIN_ROLE_NAME);
            }
        ])
            ->first();
    }
}
