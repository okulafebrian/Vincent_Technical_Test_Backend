<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
        ];
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class);
    }

    public function proposal(): HasOne
    {
        return $this->hasOne(Proposal::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
