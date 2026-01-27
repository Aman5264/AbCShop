<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CustomerRetentionChart extends ChartWidget
{
    protected static ?string $heading = 'New vs Returning Customers';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        // Get new vs returning customers for the last 6 months
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('M Y'));
        }

        $newCustomers = [];
        $returningCustomers = [];

        foreach (range(5, 0) as $i) {
            $startDate = now()->subMonths($i)->startOfMonth();
            $endDate = now()->subMonths($i)->endOfMonth();

            // New customers: first order in this month
            $new = Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('user_id', function ($query) use ($startDate) {
                    $query->select('user_id')
                        ->from('orders')
                        ->groupBy('user_id')
                        ->havingRaw('MIN(created_at) >= ?', [$startDate]);
                })
                ->distinct('user_id')
                ->count('user_id');

            // Returning customers: not their first order
            $returning = Order::whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('user_id', function ($query) use ($startDate) {
                    $query->select('user_id')
                        ->from('orders')
                        ->groupBy('user_id')
                        ->havingRaw('MIN(created_at) < ?', [$startDate]);
                })
                ->distinct('user_id')
                ->count('user_id');

            $newCustomers[] = $new;
            $returningCustomers[] = $returning;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Customers',
                    'data' => $newCustomers,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.7)',
                ],
                [
                    'label' => 'Returning Customers',
                    'data' => $returningCustomers,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.7)',
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
