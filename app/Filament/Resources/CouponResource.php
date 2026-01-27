<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TernaryFilter;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Coupons';

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50)
                    ->label('Coupon Code')
                    ->placeholder('e.g., SAVE20'),
                
                \Filament\Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'fixed' => 'Fixed Amount (₹)',
                        'percentage' => 'Percentage (%)',
                    ])
                    ->native(false),
                
                \Filament\Forms\Components\TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->label('Discount Value'),
                
                \Filament\Forms\Components\TextInput::make('min_order_amount')
                    ->numeric()
                    ->minValue(0)
                    ->label('Minimum Order Amount')
                    ->placeholder('Optional'),
                
                \Filament\Forms\Components\DatePicker::make('expiry_date')
                    ->label('Expiry Date')
                    ->native(false),
                
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fixed' => 'success',
                        'percentage' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'fixed' => 'Fixed (₹)',
                        'percentage' => 'Percentage (%)',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('value')
                    ->sortable()
                    ->formatStateUsing(function ($record) {
                        return $record->type === 'percentage' 
                            ? $record->value . '%' 
                            : '₹' . number_format($record->value, 2);
                    }),
                
                Tables\Columns\TextColumn::make('min_order_amount')
                    ->label('Min. Order')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? '₹' . number_format($state, 2) : '-'),
                
                Tables\Columns\TextColumn::make('expiry_date')
                    ->date()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
