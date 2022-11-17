<?php

namespace App\Enums;

class UserRole
{
    const USER               = 0;
    const ADMIN              = 10;
    const SUPERADMIN         = 99;

    public function alias($data)
    {

        switch ($data) {
            case '10':
                return 'ADMIN';
                break;
            case '99':
                return 'SUPERADMIN';
                break;

            default:
                return 'USER';
                break;
        }
    }
}
