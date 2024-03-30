<?php

use App\Actions\Users\DeleteUserAction;
use App\Models\User;

use function Pest\Laravel\assertDatabaseMissing;

uses()->group('actions', 'users');

it('deve deletar usuário', function (): void {
    $user = User::factory()->create();

    (new DeleteUserAction())->execute($user);

    assertDatabaseMissing(User::class, [
        'id' => $user->id,
    ]);
});
