<?php

namespace Database\Factories;

use App\Models\ScanRun;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScanRun>
 */
class ScanRunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = fake()->dateTimeBetween('-30 days', 'now');
        $finishedAt = fake()->dateTimeBetween($startedAt, '+30 minutes');
        $found = fake()->numberBetween(8, 45);
        $created = fake()->numberBetween(0, $found);

        return [
            'source_id' => Source::factory(),
            'status' => fake()->randomElement(['completed', 'completed', 'completed', 'failed']),
            'started_at' => $startedAt,
            'finished_at' => $finishedAt,
            'pages_scanned' => fake()->numberBetween(1, 6),
            'listings_found' => $found,
            'listings_created' => $created,
            'listings_updated' => $found - $created,
            'error_message' => null,
            'metadata' => [
                'query' => fake()->randomElement(['gaming pc', 'rtx', 'dators spelem']),
                'mode' => 'demo',
            ],
        ];
    }
}
