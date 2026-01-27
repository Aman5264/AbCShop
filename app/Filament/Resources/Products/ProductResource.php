<?php

namespace App\Filament\Resources\Products;

use Filament\Forms\Form;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Actions;
use Filament\Forms;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Grid::make(3)
                    ->schema([
                        \Filament\Forms\Components\Group::make()
                            ->schema([
                                \Filament\Forms\Components\Section::make('Product Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\RichEditor::make('description')
                                            ->columnSpanFull(),
                                    ]),
                                \Filament\Forms\Components\Section::make('Inventory & Pricing')
                                    ->schema([
                                        \Filament\Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('sku')
                                                    ->label('SKU (Stock Keeping Unit)')
                                                    ->required(),
                                                Forms\Components\TextInput::make('barcode')
                                                    ->maxLength(255),
                                            ]),
                                        \Filament\Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('price')
                                                    ->label('Price (₹)')
                                                    ->numeric()
                                                    ->required()
                                                    ->columnSpanFull(),
                                                Forms\Components\TextInput::make('cost_price')
                                                    ->label('Cost Price (₹)')
                                                    ->numeric()
                                                    ->columnSpanFull(),
                                                Forms\Components\TextInput::make('stock')
                                                    ->numeric()
                                                    ->required()
                                                    ->default(0),
                                                Forms\Components\TextInput::make('security_stock')
                                                    ->label('Safety Stock')
                                                    ->numeric()
                                                    ->default(10),
                                            ]),
                                    ]),
                                \Filament\Forms\Components\Section::make('Flash Sale')
                                    ->schema([
                                        \Filament\Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('sale_price')
                                                    ->label('Sale Price (₹)')
                                                    ->numeric()
                                                    ->lt('price')
                                                    ->columnSpanFull(),
                                                \Filament\Forms\Components\Group::make()
                                                    ->schema([
                                                        Forms\Components\DateTimePicker::make('sale_start_date')
                                                            ->label('Start Date')
                                                            ->native(false),
                                                        Forms\Components\DateTimePicker::make('sale_end_date')
                                                            ->label('End Date')
                                                            ->native(false)
                                                            ->after('sale_start_date'),
                                                    ]),
                                            ]),
                                    ]),
                            ])
                            ->columnSpan(2),
                        \Filament\Forms\Components\Group::make()
                            ->schema([
                                \Filament\Forms\Components\Section::make('Status')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_featured')
                                            ->required(),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Visible in Store')
                                            ->required()
                                            ->default(true),
                                        Forms\Components\Select::make('status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'active' => 'Active',
                                                'archived' => 'Archived',
                                            ])
                                            ->required()
                                            ->default('active'),
                                    ]),
                                \Filament\Forms\Components\Section::make('Media')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('products')
                                            ->visibility('public'),
                                    ])
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->disk('public'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'draft' => 'warning',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable()
                    ->color(fn (Product $record): string => $record->stock <= $record->security_stock ? 'danger' : 'success'),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}