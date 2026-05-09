<?php

namespace App\Filament\Resources\Listings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ListingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source.name')
                    ->label('Source')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable()
                    ->limit(48)
                    ->weight('medium')
                    ->url(fn ($record): string => $record->url)
                    ->openUrlInNewTab(),
                TextColumn::make('price_eur')
                    ->label('Price')
                    ->money('EUR', locale: 'lv')
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'sold' => 'gray',
                        'expired', 'removed' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('hardware_score')
                    ->label('Hardware')
                    ->badge()
                    ->color(fn (?int $state): string => match (true) {
                        $state === null => 'gray',
                        $state >= 80 => 'success',
                        $state >= 60 => 'info',
                        $state >= 40 => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('value_score')
                    ->label('Value')
                    ->badge()
                    ->color(fn (?int $state): string => match (true) {
                        $state === null => 'gray',
                        $state >= 80 => 'success',
                        $state >= 60 => 'info',
                        $state >= 40 => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('risk_score')
                    ->label('Risk')
                    ->badge()
                    ->color(fn (?int $state): string => match (true) {
                        $state === null => 'gray',
                        $state >= 70 => 'danger',
                        $state >= 45 => 'warning',
                        default => 'success',
                    })
                    ->sortable(),
                TextColumn::make('verdict')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): ?string => $state ? str($state)->replace('_', ' ')->title()->toString() : null)
                    ->color(fn (?string $state): string => match ($state) {
                        'good_deal' => 'success',
                        'fair_price' => 'info',
                        'overpriced' => 'warning',
                        'too_good_to_be_true' => 'danger',
                        'needs_review' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('confidence')
                    ->formatStateUsing(fn ($state): ?string => $state === null ? null : round(((float) $state) * 100).'%')
                    ->sortable(),
                TextColumn::make('first_seen_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('last_seen_at')
                    ->since()
                    ->sortable(),
                TextColumn::make('seller_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('scanRun.id')
                    ->label('Run')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('external_id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('external_hash')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('evaluated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('source_id')
                    ->relationship('source', 'name')
                    ->label('Source')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'sold' => 'Sold',
                        'expired' => 'Expired',
                        'removed' => 'Removed',
                    ]),
                SelectFilter::make('verdict')
                    ->options([
                        'good_deal' => 'Good deal',
                        'fair_price' => 'Fair price',
                        'needs_review' => 'Needs review',
                        'overpriced' => 'Overpriced',
                        'too_good_to_be_true' => 'Too good to be true',
                    ]),
            ])
            ->defaultSort('value_score', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
