<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Kurumsal';

    protected static ?string $navigationLabel = 'Kampüs Galerisi';

    protected static ?string $modelLabel = 'Galeri Görseli';

    protected static ?string $pluralModelLabel = 'Kampüs Galerisi';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Başlık'),
            Forms\Components\TextInput::make('category')->label('Kategori')->placeholder('Kampüs, Spor, Sanat...')
                ->datalist(['Kampüs', 'Sosyal', 'Spor', 'Sanat', 'Laboratuvar']),
            SpatieMediaLibraryFileUpload::make('cover')->label('Görsel')->collection('cover')->image()->imageEditor()->columnSpanFull(),
            Forms\Components\TextInput::make('sort')->label('Sıra')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Görsel')->getStateUsing(fn (GalleryItem $r) => $r->image_url)->height(64)->width(96),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->weight('medium'),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->badge()->color('warning'),
                Tables\Columns\ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->label('Kategori')
                    ->options(fn () => GalleryItem::query()->whereNotNull('category')->distinct()->pluck('category', 'category')->all()),
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
            'index' => Pages\ManageGalleryItems::route('/'),
        ];
    }
}
