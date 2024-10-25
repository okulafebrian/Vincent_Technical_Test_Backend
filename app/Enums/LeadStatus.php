<?php

namespace App\Enums;

enum LeadStatus: int
{
    case NEW = 1;
    case FOLLOW_UP = 2;
    case SURVEY = 3;
    case PROPOSAL = 4;
    case CLOSED = 5;

    public function getLabelText(): string
    {
        return match ($this) {
            self::NEW => 'New',
            self::FOLLOW_UP => 'Follow Up',
            self::SURVEY => 'Survey',
            self::PROPOSAL => 'Final Proposal',
            self::CLOSED => 'Closed',
        };
    }
}
