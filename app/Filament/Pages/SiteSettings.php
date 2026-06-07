<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Site Ayarları';

    protected static ?string $navigationLabel = 'Site Ayarları';

    protected static ?string $title = 'Site Ayarları';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::map());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make()->tabs([
                    Forms\Components\Tabs\Tab::make('Genel')->icon('heroicon-o-home')->schema([
                        Forms\Components\TextInput::make('site_name')->label('Site Adı'),
                        Forms\Components\TextInput::make('site_slogan')->label('Slogan'),
                        Forms\Components\TextInput::make('founded_year')->label('Kuruluş Yılı'),
                        Forms\Components\Textarea::make('site_description')->label('Site Açıklaması (SEO)')->rows(2)->columnSpanFull(),
                    ])->columns(2),
                    Forms\Components\Tabs\Tab::make('Hero / Ana Sayfa')->icon('heroicon-o-photo')->schema([
                        Forms\Components\TextInput::make('hero_title')->label('Hero Başlığı')->columnSpanFull(),
                        Forms\Components\Textarea::make('hero_subtitle')->label('Hero Alt Başlığı')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('hero_image')->label('Hero Görsel URL')->columnSpanFull(),
                    ]),
                    Forms\Components\Tabs\Tab::make('İletişim')->icon('heroicon-o-phone')->schema([
                        Forms\Components\TextInput::make('contact_phone')->label('Telefon'),
                        Forms\Components\TextInput::make('contact_phone_2')->label('Telefon 2 / GSM'),
                        Forms\Components\TextInput::make('contact_email')->label('E-posta')->email(),
                        Forms\Components\TextInput::make('whatsapp')->label('WhatsApp (905...)'),
                        Forms\Components\Textarea::make('contact_address')->label('Adres')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('contact_map')->label('Harita Embed URL')->columnSpanFull(),
                    ])->columns(2),
                    Forms\Components\Tabs\Tab::make('Sosyal Medya')->icon('heroicon-o-share')->schema([
                        Forms\Components\TextInput::make('social_facebook')->label('Facebook')->url(),
                        Forms\Components\TextInput::make('social_instagram')->label('Instagram')->url(),
                        Forms\Components\TextInput::make('social_youtube')->label('YouTube')->url(),
                        Forms\Components\TextInput::make('social_linkedin')->label('LinkedIn')->url(),
                    ])->columns(2),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            Setting::put($key, $value);
        }

        Notification::make()->title('Ayarlar kaydedildi')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Kaydet')
                ->submit('save'),
        ];
    }
}
