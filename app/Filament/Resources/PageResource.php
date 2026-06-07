<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Kurumsal';

    protected static ?string $navigationLabel = 'Sayfa İçerikleri';

    protected static ?string $modelLabel = 'Sayfa';

    protected static ?string $pluralModelLabel = 'Kurumsal Sayfalar';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Başlık')->required(),
            Forms\Components\TextInput::make('key')
                ->label('Anahtar')
                ->required()
                ->unique(ignoreRecord: true)
                ->helperText('Sistemsel anahtar (vizyon, misyon, tarihce). Dikkatli değiştirin.'),
            Forms\Components\TextInput::make('subtitle')->label('Alt Başlık')->columnSpanFull(),
            Forms\Components\TextInput::make('icon')->label('İkon')->placeholder('heroicon-o-eye'),
            Forms\Components\TextInput::make('sort')->label('Sıra')->numeric()->default(0),
            Forms\Components\RichEditor::make('body')->label('İçerik')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->weight('medium'),
                Tables\Columns\TextColumn::make('key')->label('Anahtar')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('subtitle')->label('Alt Başlık')->limit(50)->color('gray'),
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
            'index' => Pages\ManagePages::route('/'),
        ];
    }
}
