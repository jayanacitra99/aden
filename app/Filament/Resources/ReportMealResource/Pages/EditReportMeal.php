<?php

namespace App\Filament\Resources\ReportMealResource\Pages;

use App\Filament\Resources\ReportMealResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportMeal extends EditRecord
{
    protected static string $resource = ReportMealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
