<?php

namespace App\Models;

use App\Enums\AccessControl\Role;
use Illuminate\Database\Eloquent\Casts\{AsCollection, AsEnumCollection};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasAnyRole(Role ...$roles): bool
    {
        return $this->roles
            ->map(fn (Role $role): string => $role->value)
            ->intersect(collect($roles)->map(fn (Role $role): string => $role->value))
            ->isNotEmpty();
    }

    public function hasAnyPermission(string ...$permissions): bool
    {
        return $this->permissions->intersect(collect($permissions))->isNotEmpty();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'roles' => AsEnumCollection::of(Role::class),
            'permissions' => AsCollection::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            if (! $user->roles) {
                $user->roles = [Role::USER];
            }
        });
    }
}
