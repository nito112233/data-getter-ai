<?php

namespace Database\Factories;

use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Source>
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['SS.com', 'Facebook Marketplace', 'Manual Import']),
            'type' => fake()->randomElement(['marketplace', 'manual']),
            'base_url' => fake()->url(),
            'search_url' => fake()->url(),
            'region' => fake()->randomElement(['Riga', 'Latvia', 'Jelgava', 'Liepaja']),
            'is_active' => true,
            'last_scanned_at' => fake()->optional()->dateTimeBetween('-14 days', 'now'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
