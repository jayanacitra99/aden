<?php

namespace App\Filament\Resources\ReportAccidentResource\Pages;

use App\Filament\Resources\ReportAccidentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportAccident extends EditRecord
{
    protected static string $resource = ReportAccidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
