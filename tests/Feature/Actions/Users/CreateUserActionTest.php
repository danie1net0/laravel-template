<?php

use App\Actions\Users\CreateUserAction;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseHas;

uses()->group('actions', 'users');

it('deve criar usuário', function (): void {
    $input = User::factory()
        ->set('roles', $roles = [Role::ADMIN])
        ->make()
        ->toArray();

    $input['password'] = 'password';

    $user = (new CreateUserAction())->execute($input);

    expect(Hash::check('password', $user->password))->toBeTrue()
        ->and($user->roles)->toEqual(collect($roles));

    assertDatabaseHas(User::class, [
        'id' => $user->id,
        'name' => $input['name'],
        'email' => $input['email'],
        'email_verified_at' => now(),
    ]);
});

it('deve atributir a role \'USER\' por padrão', function (): void {
    $input = User::factory()->make();

    (new CreateUserAction())->execute($input->toArray());

    expect(User::first()->roles)->toEqual(collect([Role::USER]));
});

it('deve criar usuário sem senha', function (): void {
    $input = User::factory()->make();

    (new CreateUserAction())->execute($input->toArray());

    assertDatabaseHas(User::class, [
        'id' => User::first()->id,
        'password' => null,
    ]);
});
