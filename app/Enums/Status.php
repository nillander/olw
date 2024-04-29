<?php

namespace App\Enums;

enum Status: string
{
    case PENDING = 'P';
    case APPROVED = 'A';
    case CANCELED = 'C';
}
