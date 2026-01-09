<?php

namespace App\Filament\Widgets;

use App\Models\CapaTicket;
use Filament\Widgets\ChartWidget;

class CapaStatusChart extends ChartWidget
{
    protected static ?string $heading = 'CAPA Ticket Status';

    protected function getData(): array
    {
        $data = CapaTicket::groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#ef4444', // OPEN - Red
                        '#f59e0b', // ON PROGRESS - Amber
                        '#10b981', // CLOSED - Emerald
                    ],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
