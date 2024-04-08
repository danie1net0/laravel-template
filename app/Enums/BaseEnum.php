<?php

namespace App\Enums;

trait BaseEnum
{
    public static function getOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])
            ->all();
    }
}
