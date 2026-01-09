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
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class MonthlyReportsChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Reports Trend';
    protected static ?string $maxHeight = '300px';

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Sections',
            'Services' => 'Services',
            'Meals' => 'Meals',
            'Meetings' => 'Meetings',
            'Accidents' => 'Accidents',
            'Medical' => 'Medical',
            'Vehicles' => 'Vehicles',
            'Waste' => 'Waste',
            'Others' => 'Others',
        ];
    }

    protected function getData(): array
    {
        $months = [];
        $datasets = [];

        $reportModels = [
            'Services' => ReportService::class,
            'Meals' => ReportMeal::class,
            'Meetings' => ReportMeeting::class,
            'Accidents' => ReportAccident::class,
            'Medical' => ReportMedical::class,
            'Vehicles' => ReportVehicle::class,
            'Waste' => ReportWaste::class,
            'Others' => ReportOther::class,
        ];

        $colors = [
            'Services' => '#3b82f6', // Blue
            'Meals' => '#10b981',    // Emerald
            'Meetings' => '#f59e0b', // Amber
            'Accidents' => '#ef4444', // Red
            'Medical' => '#8b5cf6',   // Violet
            'Vehicles' => '#ec4899',  // Pink
            'Waste' => '#6b7280',    // Gray
            'Others' => '#06b6d4',   // Cyan
        ];

        $activeFilter = $this->filter;

        foreach ($reportModels as $label => $model) {
            if ($activeFilter !== 'all' && $activeFilter !== $label) {
                continue;
            }

            $datasets[$label] = [
                'label' => $label,
                'data' => [],
                'borderColor' => $colors[$label],
                'backgroundColor' => $colors[$label],
            ];
        }

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            foreach ($reportModels as $label => $model) {
                if ($activeFilter !== 'all' && $activeFilter !== $label) {
                    continue;
                }

                $count = $model::whereMonth('report_month', $month->month)
                    ->whereYear('report_month', $month->year)
                    ->count();
                $datasets[$label]['data'][] = $count;
            }
        }

        return [
            'datasets' => array_values($datasets),
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
