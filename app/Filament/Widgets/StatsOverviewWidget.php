<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Assuming $stats is defined elsewhere or will be added by the user.
        // For this change, we are replacing the existing Stat definitions.
        $stats = [
            'revenue' => Order::sum('total_price'),
            'orders' => Order::count(),
            'users' => User::count(),
        ];

        return [
            Stat::make('Total Revenue', '₹' . number_format($stats['revenue'], 2))
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Total Orders', $stats['orders'])
                ->description('3% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('danger'),
            Stat::make('Total Users', $stats['users'])
                ->description('New signups')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('primary'),

        ];
    }
}
