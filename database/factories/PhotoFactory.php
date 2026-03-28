<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Wedding;
use App\Models\User;

/**
 * @extends Factory<Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'wedding_id' => Wedding::factory(),
        'visitor_id' => User::factory()->visitor(),
        'image_url'  => fake()->imageUrl(640, 480, 'wedding'),
    ];
}
}
