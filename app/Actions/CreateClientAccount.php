<?php

namespace App\Actions;

use App\Events\ClientAccountCreated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateClientAccount
{
    public function execute($lead)
    {
        $user = User::create([
            'role_id' => Role::CLIENT,
            'name' => $lead->name,
            'phone' => $lead->phone,
            'email' => $lead->email,
            'password' => Hash::make('password'),
        ]);

        event(new ClientAccountCreated($user));
    }
}
