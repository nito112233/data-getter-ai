<?php

namespace App\Filament\Resources\ScanRuns\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ScanRunInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Run')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('source.name')
                            ->label('Source'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'completed' => 'success',
                                'running' => 'warning',
                                'queued' => 'gray',
                                'failed' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('started_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('finished_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
                Section::make('Results')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('pages_scanned')
                            ->numeric(),
                        TextEntry::make('listings_found')
                            ->numeric(),
                        TextEntry::make('listings_created')
                            ->numeric(),
                        TextEntry::make('listings_updated')
                            ->numeric(),
                    ]),
                Section::make('Diagnostics')
                    ->schema([
                        TextEntry::make('error_message')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        KeyValueEntry::make('metadata')
                            ->placeholder('-')
                            ->columnSpanFull(),
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
