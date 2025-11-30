<?php

namespace App\Enums;

enum TaskStatus: int {
    case PENDING = 1;
    case IN_PROGRESS = 2;
    case COMPLETED = 3;
}
