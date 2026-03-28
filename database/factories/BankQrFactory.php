<?php

namespace Database\Factories;

use App\Models\BankQr;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Wedding;
use App\Models\User;

/**
 * @extends Factory<BankQr>
 */
class BankQrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'wedding_id'     => Wedding::factory(),
        'bank_name'      => fake()->randomElement(['Maybank', 'CIMB', 'Public Bank', 'RHB', 'Hong Leong']),
        'account_name'   => fake()->name(),
        'account_number' => fake()->numerify('############'),
        'qr_image'       => null,
        'is_published'   => true,
    ];
}
}
