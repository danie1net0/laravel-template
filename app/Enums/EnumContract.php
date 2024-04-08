<?php

namespace App\Enums;

interface EnumContract
{
    public function getLabel(): string;

    public static function getOptions(): array;
}
