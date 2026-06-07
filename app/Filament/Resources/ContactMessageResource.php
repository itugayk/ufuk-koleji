<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Başvurular & Mesajlar';

    protected static ?string $navigationLabel = 'İletişim Mesajları';

    protected static ?string $modelLabel = 'Mesaj';

    protected static ?string $pluralModelLabel = 'İletişim Mesajları';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_read', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Ad Soyad')->required(),
            Forms\Components\TextInput::make('email')->label('E-posta')->email(),
            Forms\Components\TextInput::make('phone')->label('Telefon'),
            Forms\Components\TextInput::make('subject')->label('Konu'),
            Forms\Components\Textarea::make('message')->label('Mesaj')->rows(5)->required()->columnSpanFull(),
            Forms\Components\Toggle::make('is_read')->label('Okundu')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\IconColumn::make('is_read')->label('Okundu')->boolean(),
                Tables\Columns\TextColumn::make('name')->label('Gönderen')->searchable()->weight('medium')
                    ->description(fn (ContactMessage $r) => $r->email ?: $r->phone),
                Tables\Columns\TextColumn::make('subject')->label('Konu')->limit(40),
                Tables\Columns\TextColumn::make('message')->label('Mesaj')->limit(50)->color('gray'),
                Tables\Columns\TextColumn::make('created_at')->label('Tarih')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')->label('Okunma Durumu'),
            ])
            ->actions([
                Tables\Actions\Action::make('toggleRead')
                    ->label(fn (ContactMessage $r) => $r->is_read ? 'Okunmadı işaretle' : 'Okundu işaretle')
                    ->icon('heroicon-o-check')
                    ->action(fn (ContactMessage $r) => $r->update(['is_read' => ! $r->is_read])),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ManageContactMessages::route('/'),
        ];
    }
}
