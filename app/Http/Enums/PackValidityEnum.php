<?php

namespace App\Http\Enums;

enum PackValidityEnum: string
{
    case Annual = 'Anual';
    case Semiannual = 'Semestral';
    case Monthly = 'Mensal';
}
