<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    const SUPER_ADMIN = 1;
    const CUSTOMER_SERVICE = 2;
    const SALESPERSON = 3;
    const OPERATIONAL = 4;
    const CLIENT = 5;

    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
