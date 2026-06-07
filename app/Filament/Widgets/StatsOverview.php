<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\ContactMessage;
use App\Models\News;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $newApplications = Application::where('status', 'yeni')->count();
        $unreadMessages = ContactMessage::where('is_read', false)->count();

        return [
            Stat::make('Toplam Başvuru', Application::count())
                ->description($newApplications.' yeni başvuru')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color($newApplications > 0 ? 'warning' : 'primary')
                ->chart([3, 5, 4, 6, 8, 7, 9]),
            Stat::make('Haber & Duyuru', News::count())
                ->description(News::published()->count().' yayında')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),
            Stat::make('Okunmamış Mesaj', $unreadMessages)
                ->description('İletişim formundan gelen')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadMessages > 0 ? 'danger' : 'gray'),
            Stat::make('Veli Yorumu', Testimonial::count())
                ->description('Aktif memnuniyet yorumu')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),
        ];
    }
}
