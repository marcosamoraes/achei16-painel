<?php

namespace App\Http\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Seller = 'seller';
    case Client = 'user';
}
