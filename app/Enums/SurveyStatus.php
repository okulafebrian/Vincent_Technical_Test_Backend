<?php

namespace App\Enums;

enum SurveyStatus: int
{
    case NEW = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;

    public function getLabelText(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        };
    }
}
