<?php

namespace App\Filament\Resources\ReportMeetingResource\Pages;

use App\Filament\Resources\ReportMeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportMeetings extends ListRecords
{
    protected static string $resource = ReportMeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
