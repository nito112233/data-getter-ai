<?php

namespace App\Filament\Resources\Listings\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ListingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Listing')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title')
                            ->columnSpanFull()
                            ->weight('medium'),
                        TextEntry::make('url')
                            ->url(fn ($state): string => $state)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),
                        TextEntry::make('source.name')
                            ->label('Source'),
                        TextEntry::make('scanRun.id')
                            ->label('Scan run')
                            ->placeholder('-'),
                        TextEntry::make('price_eur')
                            ->label('Price')
                            ->money('EUR', locale: 'lv')
                            ->placeholder('-'),
                        TextEntry::make('location')
                            ->placeholder('-'),
                        TextEntry::make('seller_name')
                            ->placeholder('-'),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('description')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
                Section::make('Detected specs')
                    ->columns(2)
                    ->schema([
                        KeyValueEntry::make('detected_specs')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        ImageEntry::make('image_urls')
                            ->placeholder('-')
                            ->limit(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Evaluation')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('hardware_score')
                            ->numeric()
                            ->badge()
                            ->placeholder('-'),
                        TextEntry::make('value_score')
                            ->numeric()
                            ->badge()
                            ->placeholder('-'),
                        TextEntry::make('risk_score')
                            ->numeric()
                            ->badge()
                            ->placeholder('-'),
                        TextEntry::make('verdict')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): ?string => $state ? str($state)->replace('_', ' ')->title()->toString() : null)
                            ->placeholder('-'),
                        TextEntry::make('confidence')
                            ->formatStateUsing(fn ($state): ?string => $state === null ? null : round(((float) $state) * 100).'%')
                            ->placeholder('-'),
                        TextEntry::make('evaluated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('ai_summary')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('pros')
                            ->placeholder('-')
                            ->bulleted()
                            ->columnSpanFull(),
                        TextEntry::make('cons')
                            ->placeholder('-')
                            ->bulleted()
                            ->columnSpanFull(),
                        TextEntry::make('questions_to_ask')
                            ->placeholder('-')
                            ->bulleted()
                            ->columnSpanFull(),
                        TextEntry::make('red_flags')
                            ->placeholder('-')
                            ->bulleted()
                            ->columnSpanFull(),
                    ]),
                Section::make('Tracking')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('first_seen_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('last_seen_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('external_id')
                            ->placeholder('-'),
                        TextEntry::make('external_hash'),
                    ]),
                Section::make('Timestamps')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
