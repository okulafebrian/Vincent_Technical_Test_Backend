<?php

namespace Database\Seeders;

use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\Role;
use App\Models\SalespersonType;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Customer Service']);
        Role::create(['name' => 'Salesperson']);
        Role::create(['name' => 'Operational']);
        Role::create(['name' => 'Client']);

        SalespersonType::create(['name' => 'Residential']);
        SalespersonType::create(['name' => 'Commercial']);

        // Super Admin
        User::create([
            'role_id' => 1,
            'name' => 'Super Admin 1',
            'email' => 'superadmin1@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Customer Service
        User::create([
            'role_id' => 2,
            'name' => 'Customer Service 1',
            'email' => 'customerservice1@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Salesperson
        User::create([
            'role_id' => 3,
            'name' => 'Salesperson 1',
            'email' => 'salesperson1@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 3,
            'name' => 'Salesperson 2',
            'email' => 'salesperson2@gmail.com',
            'password' => Hash::make('password'),
        ])->salespersonPenalties()->create([
            'start' => Carbon::yesterday(),
            'end' => Carbon::tomorrow(),
        ]);

        User::create([
            'role_id' => 3,
            'name' => 'Salesperson 3',
            'email' => 'salesperson3@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // Operational
        User::create([
            'role_id' => 4,
            'name' => 'Operational 1',
            'email' => 'operational1@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 4,
            'name' => 'Operational 2',
            'email' => 'operational2@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 4,
            'name' => 'Operational 3',
            'email' => 'operational3@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
