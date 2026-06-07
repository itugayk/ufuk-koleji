<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ApplicationResource;
use App\Models\Application;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestApplications extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Son Kayıt Başvuruları';

    public function table(Table $table): Table
    {
        return $table
            ->query(Application::query()->latest()->limit(8))
            ->columns([
                Tables\Columns\TextColumn::make('student_full_name')->label('Öğrenci')->weight('medium'),
                Tables\Columns\TextColumn::make('level_name')->label('Kademe')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('parent_name')->label('Veli')
                    ->description(fn (Application $r) => $r->parent_phone),
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
                Tables\Columns\TextColumn::make('created_at')->label('Tarih')->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('incele')
                    ->label('İncele')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Application $r) => ApplicationResource::getUrl('edit', ['record' => $r])),
            ]);
    }
}
