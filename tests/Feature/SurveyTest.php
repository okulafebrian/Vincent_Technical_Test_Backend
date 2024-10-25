<?php

use App\Models\User;

test('users can create new survey', function () {
    $operational = User::where('role_id', 3)->first();

    $this->post('/login', [
        'email' => $operational->email,
        'password' => 'password',
    ]);

    $this->post(
        '/api/surveys',
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
