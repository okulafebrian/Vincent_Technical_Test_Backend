<?php

use App\Enums\ProposalStatus;
use App\Models\Role;
use App\Models\User;

test('users can create new proposal', function () {
    $salesPerson = User::where('role_id', Role::SALESPERSON)->first();

    $this->post('/login', [
        'email' => $salesPerson->email,
        'password' => 'password',
    ]);

    $this->post(
        '/api/leads',
        [
            'name' => 'Mr Test',
            'email' => 'test@example.com',
            'phone' => '082212341234',
        ],
    );

    $this->post(
        '/api/leads/1/proposals',
        [],
    )->assertStatus(201)
        ->assertJson([
            'data' => [
                'status' => ProposalStatus::NEW->getLabelText()
            ]
        ]);
});
