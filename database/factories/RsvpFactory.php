<?php

namespace Database\Factories;

use App\Models\Rsvp;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Wedding;
use App\Models\User;


/**
 * @extends Factory<Rsvp>
 */
class RsvpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $attendance = fake()->randomElement(['attending', 'not_attending']);

    return [
        'wedding_id'  => Wedding::factory(),
        'visitor_id'  => User::factory()->visitor(),
        'attendance'  => $attendance,
        'note'        => $attendance === 'not_attending' ? fake()->sentence() : null,
    ];
}
}
