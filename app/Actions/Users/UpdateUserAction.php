<?php

namespace App\Actions\Users;

use App\Models\User;

class UpdateUserAction
{
    public function execute(User $user, array $input): User
    {
        return tap($user)->update([
            'name' => $input['name'] ?? $user->name,
            'email' => $input['email'] ?? $user->email,
            'roles' => $input['roles'] ?? $user->roles,
            'is_active' => $input['is_active'] ?? $user->is_active,
        ]);
    }
}
