<?php

namespace App\Filament\Resources\Listings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Listing')
                    ->columns(2)
                    ->schema([
                        Select::make('source_id')
                            ->relationship('source', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('scan_run_id')
                            ->relationship('scanRun', 'id')
                            ->label('Scan run')
                            ->searchable(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('url')
                            ->url()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('price_eur')
                            ->label('Price')
                            ->numeric()
                            ->prefix('EUR'),
                        TextInput::make('location')
                            ->maxLength(255),
                        TextInput::make('seller_name')
                            ->maxLength(255),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'sold' => 'Sold',
                                'expired' => 'Expired',
                                'removed' => 'Removed',
                            ])
                            ->default('active')
                            ->required(),
                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                Section::make('Identifiers')
                    ->columns(2)
                    ->schema([
                        TextInput::make('external_id'),
                        TextInput::make('external_hash')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])
                    ->collapsed(),
                Section::make('Detected specs')
                    ->schema([
                        KeyValue::make('detected_specs')
                            ->keyLabel('Spec')
                            ->valueLabel('Value')
                            ->columnSpanFull(),
                        TagsInput::make('image_urls')
                            ->label('Image URLs')
                            ->columnSpanFull(),
                    ]),
                Section::make('Evaluation')
                    ->columns(3)
                    ->schema([
                        TextInput::make('hardware_score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('value_score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        TextInput::make('risk_score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        Select::make('verdict')
                            ->options([
                                'good_deal' => 'Good deal',
                                'fair_price' => 'Fair price',
                                'needs_review' => 'Needs review',
                                'overpriced' => 'Overpriced',
                                'too_good_to_be_true' => 'Too good to be true',
                            ]),
                        TextInput::make('confidence')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(1)
                            ->step(0.01),
                        DateTimePicker::make('evaluated_at'),
                        TagsInput::make('pros')
                            ->columnSpanFull(),
                        TagsInput::make('cons')
                            ->columnSpanFull(),
                        TagsInput::make('red_flags')
                            ->columnSpanFull(),
                        TagsInput::make('questions_to_ask')
                            ->columnSpanFull(),
                        Textarea::make('ai_summary')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Tracking')
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('first_seen_at'),
                        DateTimePicker::make('last_seen_at'),
                    ]),
            ]);
    }
}
