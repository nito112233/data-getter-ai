<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ScanRuns\ScanRunResource;
use App\Models\ScanRun;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestScanRuns extends TableWidget
{
    protected static ?int $sort = 30;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest scan status')
            ->query(fn (): Builder => ScanRun::query()
                ->latest('started_at')
                ->limit(6))
            ->columns([
                TextColumn::make('source.name')
                    ->label('Source'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'running' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('started_at')
                    ->since()
                    ->sortable(),
                TextColumn::make('pages_scanned')
                    ->numeric(),
                TextColumn::make('listings_found')
                    ->numeric(),
                TextColumn::make('listings_created')
                    ->numeric(),
                TextColumn::make('listings_updated')
                    ->numeric(),
            ])
            ->recordUrl(fn (ScanRun $record): string => ScanRunResource::getUrl('view', ['record' => $record]));
    }
}
