<?php

namespace App\Filament\Resources\ReportMedicalResource\Pages;

use App\Filament\Resources\ReportMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportMedical extends EditRecord
{
    protected static string $resource = ReportMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
