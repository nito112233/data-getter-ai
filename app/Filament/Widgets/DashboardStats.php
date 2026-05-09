<?php

namespace App\Filament\Widgets;

use App\Models\Listing;
use App\Models\ScanRun;
use App\Models\Source;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected static ?int $sort = 10;

    protected function getStats(): array
    {
        $latestRun = ScanRun::query()->latest('started_at')->first();
        $averagePrice = Listing::query()->whereNotNull('price_eur')->avg('price_eur');
        $averageValueScore = Listing::query()->whereNotNull('value_score')->avg('value_score');

        return [
            Stat::make('Total listings', Listing::query()->count())
                ->description(Listing::query()->where('status', 'active')->count().' active listings')
                ->color('info'),
            Stat::make('Good deals', Listing::query()->where('verdict', 'good_deal')->count())
                ->description('Listings currently marked as good value')
                ->color('success'),
            Stat::make('Latest scan', $latestRun?->status ? str($latestRun->status)->replace('_', ' ')->title()->toString() : 'No scans yet')
                ->description($latestRun?->started_at?->diffForHumans() ?? 'Seed or run a scan to populate history')
                ->color(match ($latestRun?->status) {
                    'completed' => 'success',
                    'running' => 'warning',
                    'failed' => 'danger',
                    default => 'gray',
                }),
            Stat::make('Average value', $averageValueScore === null ? '-' : round($averageValueScore).'/100')
                ->description($averagePrice === null ? 'No listing prices yet' : 'Average price EUR '.number_format((float) $averagePrice, 0))
                ->color('info'),
            Stat::make('Active sources', Source::query()->where('is_active', true)->count())
                ->description(Source::query()->count().' total configured sources')
                ->color('gray'),
        ];
    }
}
