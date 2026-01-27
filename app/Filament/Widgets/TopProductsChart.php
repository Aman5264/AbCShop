<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TopProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Top Selling Products';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get top 5 best-selling products by quantity
        $topProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Units Sold',
                    'data' => $topProducts->pluck('total_sold')->toArray(),
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(251, 146, 60, 0.7)',
                        'rgba(168, 85, 247, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                    ],
                ],
            ],
            'labels' => $topProducts->map(fn ($item) => 
                $item->product ? $item->product->name : 'Unknown'
            )->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
