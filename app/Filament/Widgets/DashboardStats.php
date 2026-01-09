<?php

namespace App\Filament\Widgets;

use App\Models\CapaTicket;
use App\Models\ReportService;
use App\Models\ReportMeal;
use App\Models\ReportMeeting;
use App\Models\ReportAccident;
use App\Models\ReportMedical;
use App\Models\ReportVehicle;
use App\Models\ReportWaste;
use App\Models\ReportOther;
use App\Models\Site;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalReports = ReportService::count() +
            ReportMeal::count() +
            ReportMeeting::count() +
            ReportAccident::count() +
            ReportMedical::count() +
            ReportVehicle::count() +
            ReportWaste::count() +
            ReportOther::count();

        return [
            Stat::make('Total Sites', Site::count())
                ->description('Active operating sites')
                ->descriptionIcon('heroicon-m-map-pin'),
            Stat::make('Open CAPA Tickets', CapaTicket::where('status', 'OPEN')->count())
                ->description('Tickets requiring immediate attention')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
            Stat::make('Total Monthly Reports', $totalReports)
                ->description('Consolidated reports across all categories')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}
