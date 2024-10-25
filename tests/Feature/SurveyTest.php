<?php

use App\Enums\SurveyStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('users can create new survey', function () {
    $operational = User::where('role_id', Role::OPERATIONAL)->first();

    $this->post('/login', [
        'email' => $operational->email,
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
        '/api/leads/1/surveys',
        [
            'notes' => 'Rumah cocok dipasang solar panel',
            'image' => UploadedFile::fake()->image('rumah.jpg')
        ],
    )->assertStatus(201)
        ->assertJson([
            'data' => [
                'notes' => 'Rumah cocok dipasang solar panel',
                'image' => 'rumah.jpg',
                'status' => SurveyStatus::NEW->getLabelText()
            ]
        ]);
});
