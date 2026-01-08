<?php

namespace App\Filament\Resources\ReportMedicalResource\Pages;

use App\Filament\Resources\ReportMedicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportMedicals extends ListRecords
{
    protected static string $resource = ReportMedicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
