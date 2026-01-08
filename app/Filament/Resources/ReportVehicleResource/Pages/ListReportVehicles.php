<?php

namespace App\Filament\Resources\ReportVehicleResource\Pages;

use App\Filament\Resources\ReportVehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportVehicles extends ListRecords
{
    protected static string $resource = ReportVehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
