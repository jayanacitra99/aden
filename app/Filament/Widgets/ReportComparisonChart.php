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

class ReportComparisonChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Report Comparison (Current Month)';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $now = Carbon::now();

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

        $counts = [];
        $labels = [];
        $backgroundColor = [
            '#3b82f6', // Blue
            '#10b981', // Emerald
            '#f59e0b', // Amber
            '#ef4444', // Red
            '#8b5cf6', // Violet
            '#ec4899', // Pink
            '#6b7280', // Gray
            '#06b6d4', // Cyan
        ];

        foreach ($reportModels as $label => $model) {
            $labels[] = $label;
            $counts[] = $model::whereMonth('report_month', $now->month)
                ->whereYear('report_month', $now->year)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Reports',
                    'data' => $counts,
                    'backgroundColor' => $backgroundColor,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
