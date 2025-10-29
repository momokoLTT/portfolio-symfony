<?php

namespace App\Data;

enum CreditType: string
{
    case CONCEPT_ART = 'designer';
    case ART_3D = 'modeler';
    case ART_2D = 'artist';
    case RIG_2D = 'rigger';

    public static function values(): array
    {
        return [
            self::CONCEPT_ART->value,
            self::ART_3D->value,
            self::ART_2D->value,
            self::RIG_2D->value,
        ];
    }

    public static function getTranslationForType(string|self $type): string
    {
        if ($type instanceof self) {
            $type = $type->value;
        }

        return match ($type) {
            self::CONCEPT_ART => 'Concept',
            self::ART_3D => 'Modeler',
            self::ART_2D => 'Artist',
            self::RIG_2D => 'Rigger',
        };
    }
}
