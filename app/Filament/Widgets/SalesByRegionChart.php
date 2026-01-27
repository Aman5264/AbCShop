<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class SalesByRegionChart extends ChartWidget
{
    protected static ?string $heading = 'Sales Distribution (Last 30 Days)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Since orders table doesn't have region/state, show daily sales distribution
        $salesData = Order::selectRaw('DATE(created_at) as sale_date, COUNT(*) as order_count, SUM(total_price) as total_revenue')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('sale_date')
            ->orderBy('sale_date', 'desc')
            ->limit(7)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Revenue ($)',
                    'data' => $salesData->pluck('total_revenue')->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(251, 146, 60, 0.7)',
                        'rgba(168, 85, 247, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                        'rgba(244, 63, 94, 0.7)',
                        'rgba(34, 197, 94, 0.7)',
                    ],
                ],
            ],
            'labels' => $salesData->map(fn ($item) => 
                date('M d', strtotime($item->sale_date))
            )->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
