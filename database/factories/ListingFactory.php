<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\ScanRun;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cpu = fake()->randomElement(['Ryzen 5 3600', 'Ryzen 5 5600', 'Ryzen 7 5800X', 'Intel i5-10400F', 'Intel i5-12400F', 'Intel i7-11700K']);
        $gpu = fake()->randomElement(['GTX 1660 Super', 'RTX 2060', 'RTX 3060', 'RTX 3070', 'RTX 4060', 'RX 6600 XT', 'RX 6700 XT']);
        $ram = fake()->randomElement([16, 16, 32]);
        $storage = fake()->randomElement(['512GB SSD', '1TB SSD', '1TB NVMe', '2TB SSD']);
        $price = fake()->numberBetween(380, 1250);
        $valueScore = fake()->numberBetween(35, 95);
        $riskScore = fake()->numberBetween(8, 76);
        $verdict = match (true) {
            $valueScore >= 82 && $riskScore <= 35 => 'good_deal',
            $valueScore >= 65 && $riskScore <= 55 => 'fair_price',
            $valueScore < 45 => 'overpriced',
            $riskScore >= 65 => 'too_good_to_be_true',
            default => 'needs_review',
        };

        return [
            'source_id' => Source::factory(),
            'scan_run_id' => ScanRun::factory(),
            'external_id' => fake()->bothify('demo-####??'),
            'external_hash' => (string) Str::uuid(),
            'url' => fake()->url(),
            'title' => "{$cpu} / {$gpu} / {$ram}GB RAM Gaming PC",
            'price_eur' => $price,
            'location' => fake()->randomElement(['Riga', 'Jelgava', 'Ogre', 'Liepaja', 'Daugavpils', 'Valmiera']),
            'seller_name' => fake()->optional()->firstName(),
            'status' => fake()->randomElement(['active', 'active', 'active', 'sold', 'expired']),
            'description' => fake()->paragraphs(2, true),
            'detected_specs' => [
                'cpu' => $cpu,
                'gpu' => $gpu,
                'ram_gb' => $ram,
                'storage' => $storage,
                'psu' => fake()->randomElement(['500W unknown', '550W Corsair', '650W Seasonic', null]),
            ],
            'image_urls' => [
                'https://placehold.co/900x600?text=Gaming+PC',
            ],
            'hardware_score' => fake()->numberBetween(45, 94),
            'value_score' => $valueScore,
            'risk_score' => $riskScore,
            'verdict' => $verdict,
            'confidence' => fake()->randomFloat(2, 0.55, 0.96),
            'red_flags' => fake()->randomElements([
                'No PSU model listed',
                'No benchmark screenshots',
                'Very short description',
                'Stock-like photos',
                'Seller avoids exact part models',
            ], fake()->numberBetween(0, 2)),
            'pros' => fake()->randomElements([
                'Strong GPU for the price',
                'Modern CPU platform',
                'Enough RAM for current games',
                'SSD storage included',
                'Listing includes useful specs',
            ], fake()->numberBetween(2, 3)),
            'cons' => fake()->randomElements([
                'Power supply details unclear',
                'Motherboard model missing',
                'Limited upgrade path',
                'Price is close to newer prebuilt options',
            ], fake()->numberBetween(1, 2)),
            'questions_to_ask' => fake()->randomElements([
                'Can you send a GPU-Z screenshot?',
                'What exact PSU model is installed?',
                'Can you share recent benchmark or stress test results?',
                'Are receipts or warranty documents available?',
            ], fake()->numberBetween(1, 3)),
            'ai_summary' => fake()->sentence(18),
            'first_seen_at' => fake()->dateTimeBetween('-45 days', '-10 days'),
            'last_seen_at' => fake()->dateTimeBetween('-9 days', 'now'),
            'evaluated_at' => fake()->dateTimeBetween('-9 days', 'now'),
        ];
    }
}
