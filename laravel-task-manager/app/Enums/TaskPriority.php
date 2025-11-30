<?php

namespace App\Enums;

enum TaskPriority: int {
    case VERY_LOW = 1;
    case LOW = 2;
    case MEDIUM = 3;
    case HIGH = 4;
    case VERY_HIGH = 5;
}
