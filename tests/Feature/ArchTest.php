<?php

use App\Enums\EnumContract;

arch('globals')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

arch('app')
    ->expect('env')->not->toBeUsed()
    ->expect('App\Http\Controllers')->toHaveSuffix('Controller')
    ->expect('App\Actions')->toHaveSuffix('Action')
    ->expect('App\Models')->toExtend('Illuminate\Database\Eloquent\Model')
    ->expect('App\Enums\*.php')->toBeTraits()
    ->expect('App\Enums\*.php')->toBeInterfaces()
    ->expect('App\Enums\**\*.php')->toBeEnums()
    ->expect('App\Enums\**\*.php')->toImplement(EnumContract::class);
