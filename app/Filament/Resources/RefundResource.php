<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefundResource\Pages;
use App\Models\RefundRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RefundResource extends Resource
{
    public static function getModel(): string
    {
        return RefundRequest::class;
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-arrow-path';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Order Management';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('status')
                    ->disabled(),
                \Filament\Forms\Components\Textarea::make('reason')
                    ->disabled(),
                \Filament\Forms\Components\Textarea::make('admin_notes'),
                \Filament\Forms\Components\DatePicker::make('pickup_date')
                    ->label('Pickup Date')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order.id')
                    ->label('Order ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->limit(50),
                Tables\Columns\TextColumn::make('pickup_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'refunded' => 'info',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve & Pickup')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn (RefundRequest $record) => $record->status === 'pending')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('pickup_date')
                            ->required()
                            ->minDate(now())
                            ->label('Schedule Pickup Date'),
                    ])
                    ->action(function (RefundRequest $record, array $data) {
                        $record->update([
                            'status' => 'approved',
                            'pickup_date' => $data['pickup_date'],
                        ]);

                        Notification::make()
                            ->title('Return Approved')
                            ->body('Pickup scheduled for ' . $data['pickup_date'])
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('process_refund')
                    ->label('Process Refund')
                    ->color('info')
                    ->icon('heroicon-o-currency-dollar')
                    ->requiresConfirmation()
                    ->visible(fn (RefundRequest $record) => $record->status === 'approved')
                    ->action(function (RefundRequest $record) {
                        $record->update(['status' => 'refunded']);

                        // Restock items
                        foreach ($record->order->items as $item) {
                            $product = $item->product;
                            if ($product) {
                                $product->increment('stock', $item->quantity);
                            }
                        }

                        Notification::make()
                            ->title('Refund Processed')
                            ->body('Stock has been restocked.')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->requiresConfirmation()
                    ->visible(fn (RefundRequest $record) => $record->status === 'pending')
                    ->action(function (RefundRequest $record) {
                        $record->update(['status' => 'rejected']);
                        
                        Notification::make()
                            ->title('Refund Rejected')
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRefunds::route('/'),
        ];
    }
}
