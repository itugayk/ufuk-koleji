<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Kurumsal';

    protected static ?string $navigationLabel = 'Başarılarımız';

    protected static ?string $modelLabel = 'Başarı';

    protected static ?string $pluralModelLabel = 'Başarılar';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Toggle::make('is_stat')
                ->label('Sayaç olarak göster')
                ->helperText('Açık ise ana sayfadaki sayaç bölümünde rakamla gösterilir.')
                ->live()
                ->columnSpanFull(),
            Forms\Components\TextInput::make('title')->label('Başlık')->required()->columnSpanFull(),
            Forms\Components\TextInput::make('value')
                ->label('Sayı (sayaç)')
                ->numeric()
                ->visible(fn (Forms\Get $get) => $get('is_stat')),
            Forms\Components\TextInput::make('suffix')
                ->label('Sonek')
                ->placeholder('+ , %')
                ->visible(fn (Forms\Get $get) => $get('is_stat')),
            Forms\Components\TextInput::make('category')->label('Kategori')->placeholder('Olimpiyat, Üniversite...')
                ->visible(fn (Forms\Get $get) => ! $get('is_stat')),
            Forms\Components\TextInput::make('year')->label('Yıl')->numeric()
                ->visible(fn (Forms\Get $get) => ! $get('is_stat')),
            Forms\Components\TextInput::make('icon')->label('İkon')->placeholder('heroicon-o-trophy'),
            Forms\Components\TextInput::make('sort')->label('Sıra')->numeric()->default(0),
            Forms\Components\Textarea::make('description')->label('Açıklama')->rows(3)->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('cover')->label('Görsel')->collection('cover')->image()
                ->visible(fn (Forms\Get $get) => ! $get('is_stat'))->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->weight('medium')
                    ->description(fn (Achievement $r) => $r->category),
                Tables\Columns\TextColumn::make('value')->label('Sayı')
                    ->formatStateUsing(fn ($state, Achievement $r) => $state ? number_format($state).$r->suffix : '—'),
                Tables\Columns\IconColumn::make('is_stat')->label('Sayaç')->boolean(),
                Tables\Columns\TextColumn::make('year')->label('Yıl')->placeholder('—'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_stat')->label('Sayaç mı?'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageAchievements::route('/'),
        ];
    }
}
