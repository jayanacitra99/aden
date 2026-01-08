<?php

namespace App\Filament\Resources\ReportMeetingResource\Pages;

use App\Filament\Resources\ReportMeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportMeeting extends EditRecord
{
    protected static string $resource = ReportMeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
