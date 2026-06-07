<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $navigationLabel = 'Etkinlik Takvimi';

    protected static ?string $modelLabel = 'Etkinlik';

    protected static ?string $pluralModelLabel = 'Etkinlikler';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Etkinlik Adı')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('slug')->label('URL (slug)')->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('location')->label('Konum'),
            Forms\Components\DateTimePicker::make('starts_at')->label('Başlangıç')->required()->seconds(false),
            Forms\Components\DateTimePicker::make('ends_at')->label('Bitiş')->seconds(false),
            Forms\Components\Textarea::make('description')->label('Açıklama')->rows(4)->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('cover')->label('Görsel')->collection('cover')->image()->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('starts_at', 'asc')
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Görsel')->getStateUsing(fn (Event $r) => $r->image_url)->height(48)->width(72),
                Tables\Columns\TextColumn::make('title')->label('Etkinlik')->searchable()->weight('medium'),
                Tables\Columns\TextColumn::make('location')->label('Konum')->color('gray'),
                Tables\Columns\TextColumn::make('starts_at')->label('Tarih')->dateTime('d.m.Y H:i')->sortable(),
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
            'index' => Pages\ManageEvents::route('/'),
        ];
    }
}
