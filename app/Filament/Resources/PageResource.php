<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Static Pages';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Grid::make(3)
                    ->schema([
                        \Filament\Forms\Components\Group::make()
                            ->schema([
                                \Filament\Forms\Components\Section::make('Content')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, \Filament\Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                        \Filament\Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                        \Filament\Forms\Components\RichEditor::make('content')
                                            ->required()
                                            ->columnSpanFull(),
                                        \Filament\Forms\Components\Textarea::make('custom_css')
                                            ->label('Custom CSS (without <style> tags)')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                        \Filament\Forms\Components\Textarea::make('custom_html')
                                            ->label('Custom HTML')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(2),
                        \Filament\Forms\Components\Group::make()
                            ->schema([
                                \Filament\Forms\Components\Section::make('Publishing')
                                    ->schema([
                                        \Filament\Forms\Components\Select::make('status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'published' => 'Published',
                                                'archived' => 'Archived',
                                            ])
                                            ->required()
                                            ->default('draft'),
                                        \Filament\Forms\Components\DateTimePicker::make('published_at'),
                                    ]),
                                \Filament\Forms\Components\Section::make('SEO')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('meta_title')
                                            ->maxLength(255),
                                        \Filament\Forms\Components\Textarea::make('meta_description')
                                            ->maxLength(255),
                                    ]),
                                \Filament\Forms\Components\Section::make('Visibility')
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('is_active')
                                            ->required()
                                            ->default(true),
                                    ]),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'warning',
                    }),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('view_on_site')
                    ->label('View on Site')
                    ->icon('heroicon-o-globe-alt')
                    ->url(fn (Page $record): string => route('pages.show', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
