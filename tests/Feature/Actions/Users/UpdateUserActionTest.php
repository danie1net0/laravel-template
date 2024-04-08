<?php

use App\Actions\Users\UpdateUserAction;
use App\Enums\AccessControl\Role;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;

uses()->group('actions', 'users');

it('deve editar usuário', function (bool $isActive): void {
    $user = User::factory()->create();

    $input = User::factory()
        ->make([
            'roles' => $roles = [Role::ADMIN],
            'is_active' => $isActive,
        ]);

    (new UpdateUserAction())->execute($user, $input->toArray());

    expect($user->roles)->toEqual(collect($roles));

    assertDatabaseHas(User::class, [
        'id' => $user->id,
        'name' => $input['name'],
        'email' => $input['email'],
        'is_active' => $input['is_active'],
    ]);
})->with([true, false]);

it('deve editar usuário sem todos parâmetro', function (string $param): void {
    $user = User::factory()->create();

    $input = User::factory()
        ->set('roles', [Role::ADMIN])
        ->make();

    $originalValue = $user->{$param};

    unset($input[$param]);

    $user = (new UpdateUserAction())->execute($user, $input->toArray());

    expect($user->{$param})->toEqual($originalValue);
})->with(['name', 'email', 'roles', 'is_active']);
