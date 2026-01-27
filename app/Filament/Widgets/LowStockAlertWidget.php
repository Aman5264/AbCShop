<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockAlertWidget extends BaseWidget
{
    protected static ?int $sort = 2; // Position below charts

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::whereColumn('stock', '<=', 'security_stock')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->color('danger'),
                Tables\Columns\TextColumn::make('security_stock')
                    ->label('Alert Level')
                    ->numeric(),
            ])
            ->paginated(false);
    }
}
