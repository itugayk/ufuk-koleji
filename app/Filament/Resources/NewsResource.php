<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    protected static ?string $navigationLabel = 'Haberler & Duyurular';

    protected static ?string $modelLabel = 'Haber / Duyuru';

    protected static ?string $pluralModelLabel = 'Haberler & Duyurular';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('İçerik')->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Başlık')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                    Forms\Components\TextInput::make('slug')
                        ->label('URL (slug)')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    Forms\Components\Textarea::make('excerpt')
                        ->label('Özet')
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Liste ve kartlarda görünen kısa açıklama.'),
                    Forms\Components\RichEditor::make('body')
                        ->label('İçerik')
                        ->columnSpanFull(),
                ]),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Görsel')->schema([
                    SpatieMediaLibraryFileUpload::make('cover')
                        ->label('Kapak Görseli')
                        ->collection('cover')
                        ->image()
                        ->imageEditor()
                        ->helperText('Boş bırakılırsa varsayılan görsel kullanılır.'),
                ]),
                Forms\Components\Section::make('Yayın Ayarları')->schema([
                    Forms\Components\Select::make('type')
                        ->label('Tür')
                        ->options(News::TYPES)
                        ->default('haber')
                        ->required(),
                    Forms\Components\Select::make('news_category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')->label('Ad')->required(),
                            Forms\Components\ColorPicker::make('color')->label('Renk')->default('#f5b301'),
                        ]),
                    Forms\Components\TagsInput::make('tags')
                        ->label('Etiketler'),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Yayın Tarihi')
                        ->default(now())
                        ->seconds(false),
                    Forms\Components\Toggle::make('is_published')
                        ->label('Yayında')
                        ->default(true),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Öne Çıkar')
                        ->helperText('Ana sayfada vurgulanır.'),
                ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Görsel')
                    ->getStateUsing(fn (News $record) => $record->image_url)
                    ->height(48)->width(72),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->limit(45)
                    ->weight('medium')
                    ->description(fn (News $record) => Str::limit(strip_tags((string) $record->excerpt), 60)),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->formatStateUsing(fn ($state) => News::TYPES[$state] ?? $state)
                    ->color(fn ($state) => $state === 'duyuru' ? 'warning' : 'primary'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Öne Çıkan')
                    ->boolean(),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Yayında'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
                    ->label('Görüntülenme')
                    ->numeric()
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tür')
                    ->options(News::TYPES),
                Tables\Filters\SelectFilter::make('news_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Yayın Durumu'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Öne Çıkan'),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
