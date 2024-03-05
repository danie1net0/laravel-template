<?php

arch('globals')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

arch('app')
    ->expect('env')->not->toBeUsed()
    ->expect('App\Http\Controllers')->toHaveSuffix('Controller')
    ->expect('App\Actions')->toHaveSuffix('Action')
    ->expect('App\Models')->toExtend('Illuminate\Database\Eloquent\Model')
    ->expect('App\Enums')->toBeEnums();
