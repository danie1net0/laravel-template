<?php

namespace App\Actions\Users;

use App\Enums\Role;
use App\Models\User;

class CreateUserAction
{
    public function execute(array $input): void
    {
        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'] ?? null,
            'roles' => $input['roles'] ?? [Role::USER],
            'email_verified_at' => now(),
        ]);
    }
}
