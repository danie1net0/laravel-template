<?php

namespace App\Actions\Users;

use App\Enums\AccessControl\Role;
use App\Models\User;

class CreateUserAction
{
    public function execute(array $input): User
    {
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'] ?? null,
            'roles' => $input['roles'] ?? [Role::USER],
            'email_verified_at' => now(),
            'is_active' => $input['is_active'] ?? true,
        ]);
    }
}
