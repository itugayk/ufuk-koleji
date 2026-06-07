<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Kurumsal';

    protected static ?string $navigationLabel = 'Veli Yorumları';

    protected static ?string $modelLabel = 'Veli Yorumu';

    protected static ?string $pluralModelLabel = 'Veli Yorumları';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Ad Soyad')->required(),
            Forms\Components\TextInput::make('role')->label('Rol / Açıklama')->placeholder('Veli – 7. Sınıf'),
            Forms\Components\Select::make('rating')->label('Puan')->options([1 => '★', 2 => '★★', 3 => '★★★', 4 => '★★★★', 5 => '★★★★★'])->default(5),
            Forms\Components\TextInput::make('sort')->label('Sıra')->numeric()->default(0),
            Forms\Components\Textarea::make('body')->label('Yorum')->rows(4)->required()->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('cover')->label('Fotoğraf')->collection('cover')->image()->avatar()->columnSpanFull(),
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
                    ->label('Foto')->circular()->getStateUsing(fn (Testimonial $r) => $r->image_url),
                Tables\Columns\TextColumn::make('name')->label('Ad Soyad')->searchable()->weight('medium')
                    ->description(fn (Testimonial $r) => $r->role),
                Tables\Columns\TextColumn::make('body')->label('Yorum')->limit(60)->color('gray'),
                Tables\Columns\TextColumn::make('rating')->label('Puan')->formatStateUsing(fn ($state) => str_repeat('★', (int) $state))->color('warning'),
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
            'index' => Pages\ManageTestimonials::route('/'),
        ];
    }
}
