<?php

use App\Enums\LeadStatus;
use App\Models\User;

test('users can create new lead', function () {
    $customerService = User::where('role_id', 2)->first();

    $this->post('/login', [
        'email' => $customerService->email,
        'password' => 'password',
    ]);

    $this->post(
        '/api/leads',
        [
            'name' => 'Mr Test',
            'email' => 'test@example.com',
            'phone' => '082212341234',
        ],
    )->assertStatus(201)
        ->assertJson([
            'data' => [
                'name' => 'Mr Test',
                'email' => 'test@example.com',
                'phone' => '082212341234',
                'status' => LeadStatus::NEW->getLabelText()
            ]
        ]);
});
