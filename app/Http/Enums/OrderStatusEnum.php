<?php

namespace App\Http\Enums;

enum OrderStatusEnum: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Canceled = 'canceled';
    case Reimbursed = 'reimbursed';
}
