<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\ScanRun;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ],
        );

        $sources = collect([
            [
                'name' => 'SS.com',
                'type' => 'marketplace',
                'base_url' => 'https://www.ss.com',
                'search_url' => 'https://www.ss.com/lv/electronics/computers/pc/',
                'region' => 'Latvia',
                'notes' => 'Primary source for used desktop gaming PCs.',
            ],
            [
                'name' => 'Facebook Marketplace',
                'type' => 'manual',
                'base_url' => 'https://www.facebook.com/marketplace',
                'search_url' => null,
                'region' => 'Latvia',
                'notes' => 'Manual import placeholder for listings pasted into the app later.',
            ],
            [
                'name' => 'Manual Import',
                'type' => 'manual',
                'base_url' => null,
                'search_url' => null,
                'region' => 'Riga',
                'notes' => 'For one-off listings collected outside automated scans.',
            ],
        ])->map(fn (array $source): Source => Source::query()->updateOrCreate(
            ['name' => $source['name'], 'region' => $source['region']],
            [
                ...$source,
                'is_active' => true,
                'last_scanned_at' => Carbon::now()->subDays(rand(1, 7)),
            ],
        ));

        $sources->each(function (Source $source): void {
            ScanRun::factory()
                ->count(3)
                ->create([
                    'source_id' => $source->id,
                    'status' => 'completed',
                ]);
        });

        $scanRuns = ScanRun::query()->with('source')->get();
        $pcTemplates = [
            ['Ryzen 5 5600', 'RTX 3060', 16, '1TB NVMe', 690, 82, 88, 18, 'good_deal'],
            ['Ryzen 7 5800X', 'RTX 3070', 32, '1TB SSD', 920, 91, 83, 24, 'good_deal'],
            ['Intel i5-12400F', 'RTX 4060', 16, '1TB NVMe', 760, 79, 75, 28, 'fair_price'],
            ['Ryzen 5 3600', 'GTX 1660 Super', 16, '512GB SSD', 430, 58, 66, 31, 'fair_price'],
            ['Intel i7-11700K', 'RTX 2060', 16, '1TB SSD', 780, 66, 42, 47, 'overpriced'],
            ['Ryzen 5 5600', 'RX 6700 XT', 32, '1TB NVMe', 740, 85, 90, 21, 'good_deal'],
            ['Intel i5-10400F', 'RTX 3060 Ti', 16, '512GB SSD', 590, 76, 86, 67, 'too_good_to_be_true'],
            ['Ryzen 7 3700X', 'RTX 2080 Super', 32, '2TB SSD', 840, 83, 71, 39, 'fair_price'],
            ['Intel i5-9400F', 'GTX 1650', 16, '512GB SSD', 520, 42, 33, 52, 'overpriced'],
            ['Ryzen 5 7500F', 'RTX 4070', 32, '1TB NVMe', 1220, 94, 78, 20, 'fair_price'],
        ];

        $locations = ['Riga', 'Jelgava', 'Ogre', 'Liepaja', 'Daugavpils', 'Valmiera'];

        foreach (range(1, 36) as $index) {
            $scanRun = $scanRuns->random();
            [$cpu, $gpu, $ram, $storage, $price, $hardwareScore, $valueScore, $riskScore, $verdict] = $pcTemplates[array_rand($pcTemplates)];
            $seenAt = Carbon::now()->subDays(rand(1, 35));

            Listing::query()->updateOrCreate(
                ['external_hash' => "demo-listing-{$index}"],
                [
                    'source_id' => $scanRun->source_id,
                    'scan_run_id' => $scanRun->id,
                    'external_id' => "demo-{$index}",
                    'url' => "https://example.test/listings/demo-{$index}",
                    'title' => "{$cpu} / {$gpu} / {$ram}GB RAM Gaming PC",
                    'price_eur' => $price + rand(-80, 120),
                    'location' => $locations[array_rand($locations)],
                    'seller_name' => fake()->firstName(),
                    'status' => fake()->randomElement(['active', 'active', 'active', 'sold', 'expired']),
                    'description' => "Gaming desktop with {$cpu}, {$gpu}, {$ram}GB RAM and {$storage}. Demo listing used for dashboard development.",
                    'detected_specs' => [
                        'cpu' => $cpu,
                        'gpu' => $gpu,
                        'ram_gb' => $ram,
                        'storage' => $storage,
                        'psu' => fake()->randomElement(['500W unknown', '550W Corsair CX', '650W Seasonic Focus', '650W be quiet!']),
                    ],
                    'image_urls' => ['https://placehold.co/900x600?text=Gaming+PC'],
                    'hardware_score' => $hardwareScore,
                    'value_score' => $valueScore,
                    'risk_score' => $riskScore,
                    'verdict' => $verdict,
                    'confidence' => fake()->randomFloat(2, 0.62, 0.95),
                    'red_flags' => fake()->randomElements([
                        'No PSU model listed',
                        'No benchmark screenshots',
                        'Short description',
                        'Seller has not listed motherboard model',
                    ], rand(0, 2)),
                    'pros' => fake()->randomElements([
                        'Good GPU performance for 1080p gaming',
                        'Enough RAM for current games',
                        'SSD storage included',
                        'Reasonable platform for upgrades',
                    ], rand(2, 3)),
                    'cons' => fake()->randomElements([
                        'Power supply details should be confirmed',
                        'Motherboard model missing',
                        'Ask about thermals under load',
                        'Warranty status unknown',
                    ], rand(1, 2)),
                    'questions_to_ask' => fake()->randomElements([
                        'Can you send a GPU-Z screenshot?',
                        'What exact PSU model is installed?',
                        'Can you share a recent 3DMark or game benchmark?',
                        'Do you have receipts or warranty documents?',
                    ], rand(1, 3)),
                    'ai_summary' => fake()->sentence(16),
                    'first_seen_at' => $seenAt,
                    'last_seen_at' => (clone $seenAt)->addDays(rand(0, 9)),
                    'evaluated_at' => Carbon::now()->subDays(rand(0, 7)),
                    'created_at' => $seenAt,
                    'updated_at' => Carbon::now()->subDays(rand(0, 5)),
                ],
            );
        }
    }
}
