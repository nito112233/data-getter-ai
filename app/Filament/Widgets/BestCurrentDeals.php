<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Listings\ListingResource;
use App\Models\Listing;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class BestCurrentDeals extends TableWidget
{
    protected static ?int $sort = 20;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Best current deals')
            ->query(fn (): Builder => Listing::query()
                ->where('status', 'active')
                ->orderByDesc('value_score')
                ->orderBy('risk_score')
                ->limit(8))
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(44)
                    ->weight('medium'),
                TextColumn::make('source.name')
                    ->label('Source'),
                TextColumn::make('price_eur')
                    ->label('Price')
                    ->money('EUR', locale: 'lv')
                    ->sortable(),
                TextColumn::make('location'),
                TextColumn::make('value_score')
                    ->label('Value')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('hardware_score')
                    ->label('Hardware')
                    ->badge()
                    ->color('info'),
                TextColumn::make('verdict')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): ?string => $state ? str($state)->replace('_', ' ')->title()->toString() : null)
                    ->color(fn (?string $state): string => match ($state) {
                        'good_deal' => 'success',
                        'fair_price' => 'info',
                        default => 'gray',
                    }),
            ])
            ->recordUrl(fn (Listing $record): string => ListingResource::getUrl('view', ['record' => $record]));
    }
}
