<?php

namespace App\Filament\Resources\ScanRuns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ScanRunForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Run')
                    ->columns(2)
                    ->schema([
                        Select::make('source_id')
                            ->relationship('source', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'queued' => 'Queued',
                                'running' => 'Running',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                            ])
                            ->default('queued')
                            ->required(),
                        DateTimePicker::make('started_at'),
                        DateTimePicker::make('finished_at'),
                    ]),
                Section::make('Results')
                    ->columns(4)
                    ->schema([
                        TextInput::make('pages_scanned')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('listings_found')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('listings_created')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('listings_updated')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ]),
                Section::make('Diagnostics')
                    ->schema([
                        Textarea::make('error_message')
                            ->rows(3)
                            ->columnSpanFull(),
                        KeyValue::make('metadata')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
