<?php

namespace App\Models;

use App\Enums\ProposalStatus;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => ProposalStatus::class,
        ];
    }
}
