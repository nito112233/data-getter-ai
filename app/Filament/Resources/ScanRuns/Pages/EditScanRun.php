<?php

namespace App\Filament\Resources\ScanRuns\Pages;

use App\Filament\Resources\ScanRuns\ScanRunResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditScanRun extends EditRecord
{
    protected static string $resource = ScanRunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
