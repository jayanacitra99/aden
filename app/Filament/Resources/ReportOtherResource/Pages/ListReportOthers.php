<?php

namespace App\Filament\Resources\ReportOtherResource\Pages;

use App\Filament\Resources\ReportOtherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportOthers extends ListRecords
{
    protected static string $resource = ReportOtherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
