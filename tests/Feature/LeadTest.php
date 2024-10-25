<?php

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
            'email' => 'test@example.com',
            'phone' => '082212341234',
        ],
        [
            'Authorization' => 'test'
        ]
    )->assertStatus(201)
        ->assertJson([
            'data' => [
                'email' => 'test@example.com',
                'phone' => '082212341234',
            ]
        ]);
});
