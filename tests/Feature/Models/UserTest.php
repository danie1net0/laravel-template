<?php

namespace Tests\Models;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\{Carbon, Collection};
use Illuminate\Support\Facades\Hash;

uses()->group('models');

test('deve transformar email_verified_at numa instância do Carbon', function (): void {
    $user = new User(['email_verified_at' => now()]);

    expect($user->email_verified_at)->toBeInstanceOf(Carbon::class);
});

test('deve fazer hash da senha', function (): void {
    $user = new User(['password' => 'password']);

    expect(Hash::check('password', $user->password))->toBeTrue();
});

test('deve transformar as roles numa coleção do enum Role', function (): void {
    $user = new User(['roles' => [Role::USER]]);

    expect($user->roles)->toBeInstanceOf(Collection::class)
        ->and($user->roles->first())->toBeInstanceOf(Role::class);
});

test('deve transformar as permissions numa coleção', function (): void {
    $user = new User(['permissions' => ['foo', 'bar']]);

    expect($user->permissions)->toBeInstanceOf(Collection::class);
});
