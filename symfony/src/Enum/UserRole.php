<?php

namespace App\Enum;

enum UserRole: string
{
    case CLIENT = 'ROLE_CLIENT';
    case MANAGER = 'ROLE_MANAGER';
    case ADMIN = 'ROLE_ADMIN';

    public static function values(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
