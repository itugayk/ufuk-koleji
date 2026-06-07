<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicationResource\Pages;
use App\Models\Application;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Başvurular & Mesajlar';

    protected static ?string $navigationLabel = 'Kayıt Başvuruları';

    protected static ?string $modelLabel = 'Başvuru';

    protected static ?string $pluralModelLabel = 'Kayıt Başvuruları';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'yeni')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Öğrenci Bilgileri')
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    Forms\Components\TextInput::make('student_first_name')->label('Adı')->required(),
                    Forms\Components\TextInput::make('student_last_name')->label('Soyadı')->required(),
                    Forms\Components\DatePicker::make('student_birth_date')->label('Doğum Tarihi')->displayFormat('d.m.Y'),
                    Forms\Components\Select::make('student_gender')->label('Cinsiyet')->options(['kiz' => 'Kız', 'erkek' => 'Erkek']),
                    Forms\Components\Select::make('level_id')
                        ->label('Başvurulan Kademe')
                        ->options(fn () => Level::pluck('name', 'id'))
                        ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('level_name', Level::find($state)?->name))
                        ->live(),
                    Forms\Components\TextInput::make('current_school')->label('Mevcut Okul'),
                ])->columns(2),

            Forms\Components\Section::make('Veli Bilgileri')
                ->icon('heroicon-o-user-group')
                ->schema([
                    Forms\Components\TextInput::make('parent_name')->label('Veli Adı Soyadı')->required(),
                    Forms\Components\Select::make('parent_relation')->label('Yakınlık')->options(['anne' => 'Anne', 'baba' => 'Baba', 'vasi' => 'Vasi']),
                    Forms\Components\TextInput::make('parent_phone')->label('Telefon')->tel()->required(),
                    Forms\Components\TextInput::make('parent_email')->label('E-posta')->email(),
                    Forms\Components\TextInput::make('city')->label('Şehir'),
                    Forms\Components\Textarea::make('address')->label('Adres')->rows(2)->columnSpanFull(),
                    Forms\Components\Textarea::make('message')->label('Mesaj / Not')->rows(2)->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Başvuru Yönetimi')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Durum')
                        ->options(Application::STATUSES)
                        ->default('yeni')
                        ->required(),
                    Forms\Components\Textarea::make('admin_notes')->label('Yönetici Notları')->rows(3)->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('student_full_name')
                    ->label('Öğrenci')
                    ->searchable(['student_first_name', 'student_last_name'])
                    ->weight('medium')
                    ->description(fn (Application $r) => $r->level_name),
                Tables\Columns\TextColumn::make('parent_name')
                    ->label('Veli')
                    ->searchable()
                    ->description(fn (Application $r) => $r->parent_phone),
                Tables\Columns\TextColumn::make('parent_phone')->label('Telefon')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Application::STATUSES[$state] ?? $state)
                    ->color(fn ($state) => match ($state) {
                        'yeni' => 'warning',
                        'gorusuldu' => 'info',
                        'beklemede' => 'gray',
                        'kabul' => 'success',
                        'red' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Tarih')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options(Application::STATUSES),
                Tables\Filters\SelectFilter::make('level_id')->label('Kademe')->relationship('level', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListApplications::route('/'),
            'create' => Pages\CreateApplication::route('/create'),
            'edit' => Pages\EditApplication::route('/{record}/edit'),
        ];
    }
}
