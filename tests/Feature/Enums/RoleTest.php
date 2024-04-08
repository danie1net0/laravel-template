<?php

use App\Enums\AccessControl\Role;

uses()->group('enums');

test('deve retornar o label correspondente', function (): void {
    expect(Role::SUPER_ADMIN->getLabel())->toBe('Super Administrador')
        ->and(Role::ADMIN->getLabel())->toBe('Administrador')
        ->and(Role::USER)->getLabel()->toBe('Usuário');
});

test('deve retornar as opções', function (): void {
    expect(Role::getOptions())->toBe([
        Role::SUPER_ADMIN->value => Role::SUPER_ADMIN->getLabel(),
        Role::ADMIN->value => Role::ADMIN->getLabel(),
        Role::USER->value => Role::USER->getLabel(),
    ]);
});
