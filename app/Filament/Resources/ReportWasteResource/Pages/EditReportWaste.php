<?php

namespace App\Filament\Resources\ReportWasteResource\Pages;

use App\Filament\Resources\ReportWasteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportWaste extends EditRecord
{
    protected static string $resource = ReportWasteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
