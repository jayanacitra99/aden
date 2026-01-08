<?php

namespace App\Filament\Resources\ReportServicesResource\Pages;

use App\Filament\Resources\ReportServicesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportServices extends EditRecord
{
    protected static string $resource = ReportServicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
