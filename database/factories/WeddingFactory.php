<?php

namespace Database\Factories;

use App\Models\Wedding;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str; // ← add this

/**
 * @extends Factory<Wedding>
 */
class WeddingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
// WeddingFactory.php
public function definition(): array
{
    return [
        'wedding_code' => 'WED-' . strtoupper(Str::random(6)), // ← add this
        'wedder_id'    => User::factory()->wedder(),
        'bride_name'   => fake()->firstName('female'),
        'groom_name'   => fake()->firstName('male'),
        'date'         => fake()->dateTimeBetween('+1 week', '+1 year'),
        'venue'        => fake()->address(),
        'cover_photo'  => null,
        'is_published' => true,
    ];
}
}