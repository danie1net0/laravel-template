<?php

namespace Tests\Models;

use App\Models\User;
use Illuminate\Support\Carbon;
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
