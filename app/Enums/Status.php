<?php

namespace App\Enums;

enum status: string
{
    case PENDING = 'P';
    case APPROVED = 'A';
    case CANCELED = 'C';
}
