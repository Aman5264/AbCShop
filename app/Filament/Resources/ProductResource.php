<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\Products\Pages;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Product Details')
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
                                Forms\Components\Section::make('Inventory & Pricing')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('sku')
                                                    ->label('SKU')
                                                    ->required(),
                                                Forms\Components\TextInput::make('barcode')
                                                    ->maxLength(255),
                                            ]),
                                        Forms\Components\Grid::make(2)
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
                            ])
                            ->columnSpan(2),
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Status')
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
                                Forms\Components\Section::make('Media')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image_url')
                                            ->label('Main Image')
                                            ->image()
                                            ->directory('products')
                                            ->visibility('public'),
                                        Forms\Components\FileUpload::make('images')
                                            ->label('Gallery Images')
                                            ->multiple()
                                            ->image()
                                            ->directory('products/gallery')
                                            ->visibility('public'),
                                        Forms\Components\FileUpload::make('video_url')
                                            ->label('Product Video (Max 30s)')
                                            ->directory('products/videos')
                                            ->visibility('public')
                                            ->helperText('Upload a short demonstration video.'),
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
                    ->label('Image'),
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'archived' => 'Archived',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
