<?php

namespace App\Enums\AccessControl;

use App\Enums\{BaseEnum, EnumContract};

enum Role: string implements EnumContract
{
    use BaseEnum;

    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case USER = 'user';

    public function getLabel(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Administrador',
            self::ADMIN => 'Administrador',
            self::USER => 'Usuário',
        };
    }
}
