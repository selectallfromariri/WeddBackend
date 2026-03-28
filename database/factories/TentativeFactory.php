<?php

namespace Database\Factories;

use App\Models\Tentative;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Wedding;
use App\Models\User;

/**
 * @extends Factory<Tentative>
 */
class TentativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $times = ['10:00 AM', '11:00 AM', '12:00 PM', '2:00 PM', '3:00 PM', '5:00 PM', '7:00 PM'];

    return [
        'wedding_id'   => Wedding::factory(),
        'time'         => fake()->randomElement($times),
        'title'        => fake()->randomElement([
                            'Guest Arrival',
                            'Wedding Ceremony',
                            'Photo Session',
                            'Dinner',
                            'Cake Cutting',
                            'Games & Entertainment',
                          ]),
        'note'         => fake()->optional()->sentence(),
        'is_published' => true,
    ];
}
}