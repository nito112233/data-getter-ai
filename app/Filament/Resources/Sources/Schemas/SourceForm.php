<?php

namespace App\Filament\Resources\Sources\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Source')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options([
                                'marketplace' => 'Marketplace',
                                'manual' => 'Manual',
                                'retailer' => 'Retailer',
                            ])
                            ->default('marketplace')
                            ->required(),
                        TextInput::make('base_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('region')
                            ->maxLength(255),
                        Textarea::make('search_url')
                            ->rows(2)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        DateTimePicker::make('last_scanned_at'),
                        Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
