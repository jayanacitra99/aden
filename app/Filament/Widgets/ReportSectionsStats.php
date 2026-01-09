<?php

namespace App\Filament\Widgets;

use App\Models\ReportService;
use App\Models\ReportMeal;
use App\Models\ReportMeeting;
use App\Models\ReportAccident;
use App\Models\ReportMedical;
use App\Models\ReportVehicle;
use App\Models\ReportWaste;
use App\Models\ReportOther;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportSectionsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Service Reports', ReportService::count())
                ->description('Total service reports')
                ->descriptionIcon('heroicon-m-document-text'),
            Stat::make('Meal Reports', ReportMeal::count())
                ->description('Total meal reports')
                ->descriptionIcon('heroicon-m-document-text'),
            Stat::make('Meeting Reports', ReportMeeting::count())
                ->description('Total meeting reports')
                ->descriptionIcon('heroicon-m-document-text'),
            Stat::make('Accident Reports', ReportAccident::count())
                ->description('Total accident reports')
                ->descriptionIcon('heroicon-m-document-text'),
            Stat::make('Medical Reports', ReportMedical::count())
                ->description('Total medical reports')
                ->descriptionIcon('heroicon-m-document-text'),
            Stat::make('Vehicle Reports', ReportVehicle::count())
                ->description('Total vehicle reports')
                ->descriptionIcon('heroicon-m-document-text'),
            Stat::make('Waste Reports', ReportWaste::count())
                ->description('Total waste reports')
                ->descriptionIcon('heroicon-m-document-text'),
            Stat::make('Other Reports', ReportOther::count())
                ->description('Total other reports')
                ->descriptionIcon('heroicon-m-document-text'),
        ];
    }
}
