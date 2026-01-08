<?php

namespace App\Filament\Resources\ReportMealResource\Pages;

use App\Filament\Resources\ReportMealResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportMeals extends ListRecords
{
    protected static string $resource = ReportMealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
