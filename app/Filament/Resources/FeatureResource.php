<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureResource\Pages;
use App\Models\Feature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Kurumsal';

    protected static ?string $navigationLabel = 'Eğitim Modeli / Farkımız';

    protected static ?string $modelLabel = 'Özellik';

    protected static ?string $pluralModelLabel = 'Eğitim Modeli Öğeleri';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Başlık')->required(),
            Forms\Components\TextInput::make('icon')->label('İkon')->placeholder('heroicon-o-language')->helperText('Heroicon adı.'),
            Forms\Components\ColorPicker::make('color')->label('Renk')->default('#f5b301'),
            Forms\Components\TextInput::make('sort')->label('Sıra')->numeric()->default(0),
            Forms\Components\Textarea::make('description')->label('Açıklama')->rows(3)->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->weight('medium'),
                Tables\Columns\TextColumn::make('description')->label('Açıklama')->limit(60)->color('gray'),
                Tables\Columns\TextColumn::make('icon')->label('İkon')->badge()->color('gray'),
                Tables\Columns\ColorColumn::make('color')->label('Renk'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Aktif'),
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
            'index' => Pages\ManageFeatures::route('/'),
        ];
    }
}
