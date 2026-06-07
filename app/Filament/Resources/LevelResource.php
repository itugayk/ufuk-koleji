<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Kurumsal';

    protected static ?string $navigationLabel = 'Kademeler';

    protected static ?string $modelLabel = 'Kademe';

    protected static ?string $pluralModelLabel = 'Kademeler';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Kademe Bilgileri')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Kademe Adı')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                    Forms\Components\TextInput::make('slug')->label('URL (slug)')->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('tagline')->label('Slogan')->maxLength(255),
                    Forms\Components\TextInput::make('age_range')->label('Yaş / Sınıf Aralığı')->placeholder('Örn: 3 – 6 Yaş'),
                    Forms\Components\Textarea::make('summary')->label('Kısa Özet')->rows(3)->columnSpanFull(),
                    Forms\Components\RichEditor::make('body')->label('Detaylı İçerik')->columnSpanFull(),
                ])->columns(2),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Görünüm')->schema([
                    SpatieMediaLibraryFileUpload::make('cover')->label('Kapak Görseli')->collection('cover')->image()->imageEditor(),
                    Forms\Components\TextInput::make('icon')
                        ->label('İkon')
                        ->placeholder('heroicon-o-academic-cap')
                        ->helperText('Heroicon adı.'),
                    Forms\Components\ColorPicker::make('color')->label('Tema Rengi')->default('#13315c'),
                    Forms\Components\TextInput::make('sort')->label('Sıra')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Görsel')
                    ->getStateUsing(fn (Level $record) => $record->image_url)
                    ->height(48)->width(72),
                Tables\Columns\TextColumn::make('name')->label('Kademe')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('age_range')->label('Aralık')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('tagline')->label('Slogan')->limit(40)->color('gray'),
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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
