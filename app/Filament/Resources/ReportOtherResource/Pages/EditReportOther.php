<?php

namespace App\Filament\Resources\ReportOtherResource\Pages;

use App\Filament\Resources\ReportOtherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportOther extends EditRecord
{
    protected static string $resource = ReportOtherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
