<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Create 1 fixed wedder (easy to login with)
    User::factory()->wedder()->create([
        'name'  => 'Ahmad Wedder',
        'email' => 'wedder@test.com',
    ]);

    // Create 10 fixed visitors
    User::factory()->visitor()->create([
        'name'  => 'Ali Visitor',
        'email' => 'visitor@test.com',
    ]);

    // Create 20 random visitors
    User::factory()->visitor()->count(20)->create();
}
}
