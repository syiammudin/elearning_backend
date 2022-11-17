<?php

namespace App\Enums;


class UserRole
{

    const TUJUH              = 7;
    const DELAPAN            = 8;
    const SEMBILAN           = 9;
    const SEPULUH            = 10;
    const SEBELAS            = 11;
    const DUABELAS           = 12;

    public function alias($data)
    {

        switch ($data) {
            case '7':
                return 'TUJUH (VII)';
                break;
            case '8':
                return 'DELAPAN (VIII)';
                break;
            case '9':
                return 'SEMBILAN (IX)';
                break;
            case '10':
                return 'SEPULUH (X)';
                break;
            case '11':
                return 'SEBELAS (XI)';
                break;

            default:
                return 'DUABELAS (XII)';
                break;
        }
    }
    public function romawi($data)
    {

        switch ($data) {
            case '7':
                return 'VII';
                break;
            case '8':
                return 'VIII';
                break;
            case '9':
                return 'IX';
                break;
            case '10':
                return 'X';
                break;
            case '11':
                return 'XI';
                break;

            default:
                return 'XII';
                break;
        }
    }
}
