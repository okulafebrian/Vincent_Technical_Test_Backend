<?php

namespace App\Models;

use App\Enums\SurveyStatus;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => SurveyStatus::class,
        ];
    }
}
