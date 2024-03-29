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

test('deve retornar true quando o usuário tiver qualquer uma das roles especificadas', function (): void {
    $user = new User(['roles' => [Role::USER]]);

    expect($user->hasAnyRole(Role::USER))->toBeTrue();
});

test('deve retornar false quando o usuário não tiver nenhuma das roles especificadas', function (): void {
    $user = new User(['roles' => [Role::USER]]);

    expect($user->hasAnyRole(Role::ADMIN, Role::SUPER_ADMIN))->toBeFalse();
});

test('deve retornar true quando o usuário tiver mais de uma role simultaneamente', function (): void {
    $user = new User(['roles' => [Role::USER, Role::ADMIN]]);

    expect($user->hasAnyRole(Role::USER, Role::ADMIN))->toBeTrue();
});
test('deve retornar true quando o usuário tiver qualquer uma das permissions especificadas', function (): void {
    $user = new User(['permissions' => ['foo']]);

    expect($user->hasAnyPermission('foo'))->toBeTrue();
});

test('deve retornar true quando o usuário não tiver nenhuma das permissions especificadas', function (): void {
    $user = new User(['permissions' => ['foo']]);

    expect($user->hasAnyPermission('bar', 'baz'))->toBeFalse();
});

test('deve retornar true quando o usuário tiver mais de uma permission simultaneamente', function (): void {
    $user = new User(['permissions' => ['foo', 'baz']]);

    expect($user->hasAnyPermission('foo', 'baz'))->toBeTrue();
});

test('deve retornar false quando o usuário não tiver nenhuma permissão', function (): void {
    $user = new User(['permissions' => []]);

    expect($user->hasAnyPermission('foo', 'bar', 'baz'))->toBeFalse();
});
