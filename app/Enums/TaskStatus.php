<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Created = 'created';
    case Pending = 'pending';
    case Success = 'success';
    case Failed  = 'failed';
}
