<?php

use App\Enums\AccessControl\Role;

uses()->group('enums');

test('deve retornar o label correspondente', function (): void {
    expect(Role::SUPER_ADMIN->getLabel())->toBe('Super Administrador')
        ->and(Role::ADMIN->getLabel())->toBe('Administrador')
        ->and(Role::USER)->getLabel()->toBe('Usuário');
});
