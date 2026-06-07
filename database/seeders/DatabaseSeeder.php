<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Application;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Feature;
use App\Models\GalleryItem;
use App\Models\Level;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /** Unsplash görsel URL üretici. */
    private function img(string $id, int $w = 1200, int $h = 800): string
    {
        return "https://images.unsplash.com/{$id}?auto=format&fit=crop&w={$w}&h={$h}&q=80";
    }

    public function run(): void
    {
        $this->seedAdmin();
        $this->seedSettings();
        $this->seedLevels();
        $this->seedFeatures();
        $this->seedPages();
        $this->seedNews();
        $this->seedEvents();
        $this->seedAchievements();
        $this->seedGallery();
        $this->seedTestimonials();
        $this->seedApplications();
        $this->seedContactMessages();
    }

    private function seedAdmin(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ufukkoleji.com'],
            ['name' => 'Ufuk Koleji Yönetici', 'password' => Hash::make('password')]
        );
    }

    private function seedSettings(): void
    {
        $settings = [
            'site_name' => 'Ufuk Koleji',
            'site_slogan' => 'Geleceğe Açılan Ufuk',
            'site_description' => 'Anaokulundan liseye akademik başarı ve güçlü karakter eğitimini bir arada sunan kurumsal eğitim kurumu.',
            'hero_title' => 'Çocuğunuzun Ufkunu Birlikte Genişletelim',
            'hero_subtitle' => 'Anaokulundan liseye, akademik başarıyı sosyal gelişim ve değerler eğitimiyle harmanlayan modern bir eğitim yuvası.',
            'hero_image' => $this->img('photo-1509062522246-3755977927d7', 1920, 1080),
            'contact_phone' => '0212 555 00 00',
            'contact_phone_2' => '0533 555 00 00',
            'contact_email' => 'info@ufukkoleji.com',
            'contact_address' => 'Atatürk Mah. Eğitim Cad. No: 42, Ataşehir / İstanbul',
            'contact_map' => 'https://www.openstreetmap.org/export/embed.html?bbox=29.10%2C40.98%2C29.14%2C41.00&layer=mapnik',
            'social_facebook' => 'https://facebook.com',
            'social_instagram' => 'https://instagram.com',
            'social_youtube' => 'https://youtube.com',
            'social_linkedin' => 'https://linkedin.com',
            'founded_year' => '1998',
            'whatsapp' => '905335550000',
        ];

        foreach ($settings as $key => $value) {
            Setting::put($key, $value);
        }
    }

    private function seedLevels(): void
    {
        $levels = [
            [
                'name' => 'Anaokulu', 'slug' => 'anaokulu',
                'tagline' => 'Oyunla öğrenmenin keyfi', 'age_range' => '3 – 6 Yaş',
                'icon' => 'heroicon-o-puzzle-piece', 'color' => '#f5b301',
                'summary' => 'Çocuklarımızın merak duygusunu besleyen, oyun temelli ve sevgi dolu bir başlangıç.',
                'image_path' => $this->img('photo-1587616211892-f743fcca64f9'),
                'body' => "Ufuk Koleji Anaokulunda her çocuğun kendine özgü gelişim hızına saygı duyarız. Oyun temelli öğrenme yaklaşımı, drama, müzik, görsel sanatlar ve İngilizce etkinliklerle çocuklarımızın bilişsel, duygusal ve sosyal gelişimini destekleriz.\n\nGüvenli ve sıcak sınıf ortamlarımızda, çocuklarımız özgüven kazanır, paylaşmayı öğrenir ve okula severek başlar.",
            ],
            [
                'name' => 'İlkokul', 'slug' => 'ilkokul',
                'tagline' => 'Sağlam temeller', 'age_range' => '1. – 4. Sınıf',
                'icon' => 'heroicon-o-book-open', 'color' => '#13315c',
                'summary' => 'Okuma-yazma, matematik ve değerler eğitiminde güçlü bir akademik temel.',
                'image_path' => $this->img('photo-1503676260728-1c00da094a0b'),
                'body' => "İlkokul kademesinde temel akademik becerilerin yanı sıra öğrenme sevgisini ve disiplinini kazandırmayı hedefleriz. Bireysel farklılıkları gözeten öğretim yöntemlerimiz, küçük sınıf mevcutlarımız ile her öğrencimizle yakından ilgileniriz.\n\nKodlama, satranç, yabancı dil ve sanat-spor branşlarıyla zenginleştirilmiş programımız öğrencilerimizin çok yönlü gelişimini destekler.",
            ],
            [
                'name' => 'Ortaokul', 'slug' => 'ortaokul',
                'tagline' => 'Keşfet ve geliş', 'age_range' => '5. – 8. Sınıf',
                'icon' => 'heroicon-o-beaker', 'color' => '#0ea5a4',
                'summary' => 'STEM, proje temelli öğrenme ve sınavlara güçlü hazırlık.',
                'image_path' => $this->img('photo-1564981797816-1043664bf78d'),
                'body' => "Ortaokul kadememizde öğrencilerimizi hem akademik hem de kişisel olarak liselere ve hayata hazırlarız. LGS sürecini deneyimli rehberlik kadromuz ve düzenli deneme sınavlarıyla titizlikle yönetiriz.\n\nSTEM atölyeleri, münazara kulüpleri ve sosyal sorumluluk projeleriyle öğrencilerimizin eleştirel düşünme ve liderlik becerilerini geliştiririz.",
            ],
            [
                'name' => 'Lise', 'slug' => 'lise',
                'tagline' => 'Geleceğe hazır', 'age_range' => '9. – 12. Sınıf',
                'icon' => 'heroicon-o-academic-cap', 'color' => '#b91c1c',
                'summary' => 'Üniversiteye ve kariyere yönelik akademik mükemmeliyet.',
                'image_path' => $this->img('photo-1523050854058-8df90110c9f1'),
                'body' => "Lise kadememiz, öğrencilerimizi Türkiye'nin ve dünyanın en seçkin üniversitelerine hazırlar. Alanında uzman öğretmen kadrosu, bireysel koçluk sistemi ve yoğun YKS hazırlık programımızla yüksek başarı oranları elde ederiz.\n\nUluslararası değişim programları, üniversite tanıtım gezileri ve kariyer danışmanlığı ile öğrencilerimize geniş bir ufuk sunarız.",
            ],
        ];

        foreach ($levels as $i => $data) {
            Level::updateOrCreate(['slug' => $data['slug']], array_merge($data, ['sort' => $i, 'is_active' => true]));
        }
    }

    private function seedFeatures(): void
    {
        $features = [
            ['title' => 'Yabancı Dil', 'icon' => 'heroicon-o-language', 'color' => '#13315c',
             'description' => 'Anaokulundan itibaren yoğun İngilizce, ikinci yabancı dil seçenekleri ve native speaker öğretmenlerle dünya vatandaşı yetiştiriyoruz.'],
            ['title' => 'STEM & Kodlama', 'icon' => 'heroicon-o-cpu-chip', 'color' => '#0ea5a4',
             'description' => 'Robotik, kodlama ve fen atölyelerinde öğrencilerimiz üreterek öğreniyor, geleceğin teknolojilerine bugünden hazırlanıyor.'],
            ['title' => 'Sanat & Müzik', 'icon' => 'heroicon-o-paint-brush', 'color' => '#f5b301',
             'description' => 'Görsel sanatlar, müzik ve sahne sanatları atölyelerinde her öğrencinin yeteneğini keşfetmesine ve geliştirmesine olanak tanıyoruz.'],
            ['title' => 'Spor & Sağlık', 'icon' => 'heroicon-o-trophy', 'color' => '#b91c1c',
             'description' => 'Yüzme, basketbol, voleybol ve jimnastik branşlarında profesyonel antrenörler eşliğinde sağlıklı ve disiplinli nesiller yetiştiriyoruz.'],
            ['title' => 'Rehberlik & Koçluk', 'icon' => 'heroicon-o-user-group', 'color' => '#7c3aed',
             'description' => 'Bireysel akademik koçluk ve psikolojik danışmanlık ile her öğrencimizin potansiyelini en üst düzeye taşıyoruz.'],
            ['title' => 'Değerler Eğitimi', 'icon' => 'heroicon-o-heart', 'color' => '#db2777',
             'description' => 'Saygı, sorumluluk, empati ve dürüstlük değerlerini akademik başarıyla harmanlayarak karakterli bireyler yetiştiriyoruz.'],
        ];

        foreach ($features as $i => $data) {
            Feature::updateOrCreate(['title' => $data['title']], array_merge($data, ['sort' => $i, 'is_active' => true]));
        }
    }

    private function seedPages(): void
    {
        $pages = [
            ['key' => 'vizyon', 'title' => 'Vizyonumuz', 'icon' => 'heroicon-o-eye', 'sort' => 1,
             'subtitle' => 'Geleceğe yön veren bir eğitim kurumu',
             'body' => "Ufuk Koleji olarak vizyonumuz; akademik mükemmeliyeti evrensel değerlerle buluşturan, eleştirel düşünebilen, üretken, özgüvenli ve topluma duyarlı bireyler yetiştirmektir.\n\nÇağın gerektirdiği bilgi ve becerilerle donatılmış, kendi kültürüne bağlı ancak dünyaya açık öğrenciler yetiştirerek geleceğin liderlerini bugünden hazırlamayı amaçlıyoruz."],
            ['key' => 'misyon', 'title' => 'Misyonumuz', 'icon' => 'heroicon-o-flag', 'sort' => 2,
             'subtitle' => 'Her öğrencinin potansiyelini açığa çıkarmak',
             'body' => "Misyonumuz; her öğrencinin bireysel farklılıklarını gözeterek, onların akademik, sosyal ve duygusal gelişimini en üst düzeye taşımaktır.\n\nNitelikli öğretmen kadromuz, modern eğitim teknolojilerimiz ve sıcak okul ortamımızla öğrencilerimize öğrenmeyi sevdiriyor, onları hayata ve geleceğe en iyi şekilde hazırlıyoruz."],
            ['key' => 'tarihce', 'title' => 'Tarihçemiz', 'icon' => 'heroicon-o-clock', 'sort' => 3,
             'subtitle' => '1998’den bugüne kesintisiz eğitim yolculuğu',
             'body' => "Ufuk Koleji, 1998 yılında küçük bir anaokulu olarak eğitim hayatına başladı. Kurucularımızın 'her çocuk değerlidir' ilkesiyle yola çıkan kurumumuz, geçen yıllar içinde ilkokul, ortaokul ve lise kademelerini bünyesine kattı.\n\nBugün binlerce mezunuyla gurur duyan Ufuk Koleji, modern kampüsü, deneyimli kadrosu ve yenilikçi eğitim anlayışıyla bölgenin önde gelen eğitim kurumlarından biri haline gelmiştir. 25 yılı aşkın tecrübemizle geleceğe emin adımlarla ilerliyoruz."],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(['key' => $data['key']], $data);
        }
    }

    private function seedNews(): void
    {
        $categories = [
            'akademik' => ['name' => 'Akademik', 'color' => '#13315c'],
            'etkinlik' => ['name' => 'Etkinlik', 'color' => '#f5b301'],
            'basari' => ['name' => 'Başarı', 'color' => '#0ea5a4'],
            'genel' => ['name' => 'Genel', 'color' => '#64748b'],
        ];
        $catModels = [];
        foreach ($categories as $slug => $data) {
            $catModels[$slug] = NewsCategory::updateOrCreate(['slug' => $slug], array_merge($data, ['slug' => $slug]));
        }

        $news = [
            [
                'type' => 'haber', 'cat' => 'basari', 'featured' => true,
                'title' => 'Öğrencilerimiz TÜBİTAK Proje Yarışmasında Türkiye Birincisi',
                'excerpt' => 'Lise öğrencilerimizden oluşan ekip, geliştirdikleri çevre dostu su arıtma projesiyle TÜBİTAK 2204-A yarışmasında Türkiye birinciliği elde etti.',
                'image' => 'photo-1581726690015-c9861fa5057f',
                'days' => 3,
            ],
            [
                'type' => 'duyuru', 'cat' => 'akademik', 'featured' => true,
                'title' => '2026-2027 Eğitim Yılı Kayıtları Başladı',
                'excerpt' => 'Yeni eğitim öğretim yılı için ön kayıtlarımız başlamıştır. Erken kayıt avantajlarından yararlanmak için kampüsümüzü ziyaret edebilirsiniz.',
                'image' => 'photo-1427504494785-3a9ca7044f45',
                'days' => 1,
            ],
            [
                'type' => 'haber', 'cat' => 'etkinlik', 'featured' => false,
                'title' => 'Geleneksel Bilim Şenliğimiz Büyük İlgi Gördü',
                'excerpt' => 'Öğrencilerimizin yıl boyu hazırladığı bilim projeleri, velilerimiz ve misafirlerimizin yoğun katılımıyla görkemli bir şenlikte sergilendi.',
                'image' => 'photo-1503454537195-1dcabb73ffb9',
                'days' => 7,
            ],
            [
                'type' => 'haber', 'cat' => 'basari', 'featured' => false,
                'title' => 'LGS’de Yüzde 90 Başarı Oranı',
                'excerpt' => '8. sınıf öğrencilerimiz LGS sınavında büyük başarı gösterdi; öğrencilerimizin %90’ı ilk tercih ettikleri liselere yerleşti.',
                'image' => 'photo-1523240795612-9a054b0db644',
                'days' => 14,
            ],
            [
                'type' => 'duyuru', 'cat' => 'genel', 'featured' => false,
                'title' => 'Veli Bilgilendirme Toplantısı 20 Haziran’da',
                'excerpt' => 'Tüm kademelerimiz için dönem değerlendirme ve bilgilendirme toplantımız 20 Haziran Cumartesi günü konferans salonumuzda gerçekleştirilecektir.',
                'image' => 'photo-1524178232363-1fb2b075b655',
                'days' => 2,
            ],
            [
                'type' => 'haber', 'cat' => 'etkinlik', 'featured' => false,
                'title' => 'Anaokulu Mezuniyet Töreni Coşkuyla Kutlandı',
                'excerpt' => 'Minik öğrencilerimiz, hazırladıkları rengarenk gösterilerle ilkokula bir adım daha yaklaştı. Velilerimiz duygu dolu anlar yaşadı.',
                'image' => 'photo-1587616211892-f743fcca64f9',
                'days' => 20,
            ],
            [
                'type' => 'duyuru', 'cat' => 'akademik', 'featured' => false,
                'title' => 'Yaz Okulu Programımız Açıklandı',
                'excerpt' => 'İngilizce, kodlama, yüzme ve sanat atölyelerinden oluşan yaz okulu programımıza kayıtlar başlamıştır. Kontenjanlarımız sınırlıdır.',
                'image' => 'photo-1472162072942-cd5147eb3902',
                'days' => 5,
            ],
            [
                'type' => 'haber', 'cat' => 'basari', 'featured' => false,
                'title' => 'Basketbol Takımımız İl Şampiyonu',
                'excerpt' => 'Yıldız erkek basketbol takımımız, okullar arası turnuvada finalde rakibini mağlup ederek il şampiyonluğuna ulaştı.',
                'image' => 'photo-1546519638-68e109498ffc',
                'days' => 10,
            ],
        ];

        foreach ($news as $n) {
            News::updateOrCreate(
                ['slug' => Str::slug($n['title'])],
                [
                    'news_category_id' => $catModels[$n['cat']]->id,
                    'type' => $n['type'],
                    'title' => $n['title'],
                    'excerpt' => $n['excerpt'],
                    'body' => $this->paragraphs($n['excerpt']),
                    'tags' => [$categories[$n['cat']]['name']],
                    'image_path' => $this->img($n['image']),
                    'is_featured' => $n['featured'],
                    'is_published' => true,
                    'published_at' => Carbon::now()->subDays($n['days']),
                    'views' => random_int(80, 1500),
                ]
            );
        }
    }

    private function paragraphs(string $lead): string
    {
        return "<p>{$lead}</p>"
            ."<p>Ufuk Koleji olarak öğrencilerimizin akademik başarısının yanı sıra sosyal ve kültürel gelişimlerini de en az akademik başarı kadar önemsiyoruz. Bu doğrultuda yıl boyunca birbirinden değerli etkinlikler düzenliyoruz.</p>"
            ."<p>Bu gurur verici başarıda emeği geçen tüm öğretmenlerimize, öğrencilerimize ve desteklerini esirgemeyen değerli velilerimize teşekkür ederiz. Nice başarılara birlikte imza atmak dileğiyle.</p>";
    }

    private function seedEvents(): void
    {
        $events = [
            ['title' => 'Açık Kapı Günü', 'days' => 12, 'location' => 'Ana Kampüs',
             'desc' => 'Kampüsümüzü gezebilir, öğretmenlerimizle tanışabilir ve eğitim modelimizi yakından inceleyebilirsiniz.',
             'image' => 'photo-1577896851231-70ef18881754'],
            ['title' => 'Bahar Şenliği', 'days' => 25, 'location' => 'Okul Bahçesi',
             'desc' => 'Öğrencilerimizin hazırladığı stantlar, müzik dinletileri ve eğlenceli etkinliklerle dolu geleneksel bahar şenliğimiz.',
             'image' => 'photo-1492538368677-f6e0afe31dcc'],
            ['title' => 'Kariyer Günleri', 'days' => 40, 'location' => 'Konferans Salonu',
             'desc' => 'Farklı mesleklerden uzman konukların lise öğrencilerimizle deneyimlerini paylaşacağı kariyer söyleşileri.',
             'image' => 'photo-1524178232363-1fb2b075b655'],
            ['title' => 'Bilim ve Teknoloji Fuarı', 'days' => 55, 'location' => 'Spor Salonu',
             'desc' => 'STEM atölyelerimizde üretilen projelerin sergileneceği, robotik gösterilerin yapılacağı teknoloji fuarı.',
             'image' => 'photo-1518770660439-4636190af475'],
        ];

        foreach ($events as $e) {
            $start = Carbon::now()->addDays($e['days'])->setTime(10, 0);
            Event::updateOrCreate(
                ['slug' => Str::slug($e['title'])],
                [
                    'title' => $e['title'],
                    'description' => $e['desc'],
                    'location' => $e['location'],
                    'starts_at' => $start,
                    'ends_at' => (clone $start)->addHours(4),
                    'image_path' => $this->img($e['image']),
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedAchievements(): void
    {
        $stats = [
            ['title' => 'Mezun Öğrenci', 'value' => 8500, 'suffix' => '+', 'icon' => 'heroicon-o-academic-cap'],
            ['title' => 'Üniversite Yerleşme', 'value' => 96, 'suffix' => '%', 'icon' => 'heroicon-o-building-library'],
            ['title' => 'Yıllık Tecrübe', 'value' => 27, 'suffix' => '', 'icon' => 'heroicon-o-clock'],
            ['title' => 'Ulusal & Uluslararası Ödül', 'value' => 140, 'suffix' => '+', 'icon' => 'heroicon-o-trophy'],
        ];
        foreach ($stats as $i => $s) {
            Achievement::updateOrCreate(
                ['title' => $s['title']],
                array_merge($s, ['is_stat' => true, 'is_active' => true, 'sort' => $i])
            );
        }

        $stories = [
            ['title' => 'TÜBİTAK Türkiye Birinciliği', 'category' => 'Bilim', 'year' => 2025,
             'description' => 'Lise ekibimiz çevre teknolojileri kategorisinde Türkiye birinciliği kazandı.',
             'image' => 'photo-1581726690015-c9861fa5057f'],
            ['title' => 'Tıp Fakültesi Yerleşmeleri', 'category' => 'Üniversite', 'year' => 2025,
             'description' => 'Mezunlarımızdan 18’i Türkiye’nin önde gelen tıp fakültelerine yerleşti.',
             'image' => 'photo-1532094349884-543bc11b234d'],
            ['title' => 'Uluslararası Matematik Olimpiyatı', 'category' => 'Olimpiyat', 'year' => 2024,
             'description' => 'Öğrencimiz uluslararası matematik olimpiyatında gümüş madalya kazandı.',
             'image' => 'photo-1635070041078-e363dbe005cb'],
            ['title' => 'Yüzme İl Şampiyonluğu', 'category' => 'Spor', 'year' => 2025,
             'description' => 'Yüzme takımımız il genelinde 12 madalya ile şampiyonluğa ulaştı.',
             'image' => 'photo-1530549387789-4c1017266635'],
        ];
        foreach ($stories as $i => $s) {
            Achievement::updateOrCreate(
                ['title' => $s['title']],
                [
                    'title' => $s['title'], 'category' => $s['category'], 'year' => $s['year'],
                    'description' => $s['description'], 'image_path' => $this->img($s['image']),
                    'is_stat' => false, 'is_active' => true, 'sort' => $i,
                ]
            );
        }
    }

    private function seedGallery(): void
    {
        $items = [
            ['Modern Sınıflarımız', 'Kampüs', 'photo-1580582932707-520aed937b7b'],
            ['Bilim Laboratuvarı', 'Laboratuvar', 'photo-1532094349884-543bc11b234d'],
            ['Kütüphanemiz', 'Kampüs', 'photo-1521587760476-6c12a4b040da'],
            ['Spor Salonu', 'Spor', 'photo-1546519638-68e109498ffc'],
            ['Sanat Atölyesi', 'Sanat', 'photo-1564981797816-1043664bf78d'],
            ['Müzik Sınıfı', 'Sanat', 'photo-1514320291840-2e0a9bf2a9ae'],
            ['Bahçe ve Oyun Alanları', 'Kampüs', 'photo-1597392582469-a697322d5c16'],
            ['Robotik Atölyesi', 'Laboratuvar', 'photo-1518770660439-4636190af475'],
            ['Yüzme Havuzu', 'Spor', 'photo-1530549387789-4c1017266635'],
            ['Konferans Salonu', 'Kampüs', 'photo-1524178232363-1fb2b075b655'],
            ['Sosyal Etkinlikler', 'Sosyal', 'photo-1492538368677-f6e0afe31dcc'],
            ['Yemekhane', 'Kampüs', 'photo-1517248135467-4c7edcad34c4'],
        ];
        foreach ($items as $i => $it) {
            GalleryItem::updateOrCreate(
                ['title' => $it[0]],
                ['category' => $it[1], 'image_path' => $this->img($it[2]), 'sort' => $i, 'is_active' => true]
            );
        }
    }

    private function seedTestimonials(): void
    {
        $items = [
            ['Ayşe Yılmaz', 'Veli – 4. Sınıf', 5, 'photo-1494790108377-be9c29b29330',
             'Kızım Ufuk Koleji’ne başladığından beri okula gitmek için sabırsızlanıyor. Öğretmenlerin ilgisi ve okulun sıcak ortamı bizi çok mutlu ediyor.'],
            ['Mehmet Demir', 'Veli – 11. Sınıf', 5, 'photo-1507003211169-0a1dd7228f2d',
             'Oğlumun akademik gelişimi ve özgüveni gözle görülür şekilde arttı. Rehberlik kadrosunun üniversite hazırlık sürecindeki desteği paha biçilemez.'],
            ['Zeynep Kaya', 'Veli – Anaokulu', 5, 'photo-1438761681033-6461ffad8d80',
             'Minik kızımız için en doğru kararı verdiğimize eminiz. Oyunla öğrenme yaklaşımı sayesinde çok şey öğrendi ve sosyalleşti.'],
            ['Ali Şahin', 'Veli – 7. Sınıf', 4, 'photo-1500648767791-00dcc994a43e',
             'STEM ve kodlama derslerinin çocuğuma kattıkları inanılmaz. Geleceğe hazırlanan bir nesil yetiştiriyorlar.'],
            ['Fatma Öztürk', 'Mezun Velisi', 5, 'photo-1544005313-94ddf0286df2',
             'İki çocuğum da bu okuldan mezun oldu ve hayallerindeki üniversitelere yerleşti. Ufuk Koleji ailesi olmaktan gurur duyuyoruz.'],
            ['Caner Aydın', 'Veli – 9. Sınıf', 5, 'photo-1472099645785-5658abf4ff4e',
             'Sadece akademik değil, değerler eğitimine verdikleri önem çok kıymetli. Çocuğum hem başarılı hem de saygılı bir birey olarak yetişiyor.'],
        ];
        foreach ($items as $i => $t) {
            Testimonial::updateOrCreate(
                ['name' => $t[0], 'role' => $t[1]],
                ['rating' => $t[2], 'image_path' => $this->img($t[3], 400, 400), 'body' => $t[4], 'sort' => $i, 'is_active' => true]
            );
        }
    }

    private function seedApplications(): void
    {
        $levels = Level::all()->keyBy('slug');
        $samples = [
            ['ilkokul', 'Elif', 'Aksoy', 'anne', 'Seda Aksoy', '0532 111 22 33', 'seda@example.com', 'kabul'],
            ['ortaokul', 'Burak', 'Çelik', 'baba', 'Hakan Çelik', '0533 222 33 44', 'hakan@example.com', 'gorusuldu'],
            ['anaokulu', 'Defne', 'Yıldız', 'anne', 'Merve Yıldız', '0535 333 44 55', 'merve@example.com', 'yeni'],
            ['lise', 'Kerem', 'Arslan', 'baba', 'Okan Arslan', '0536 444 55 66', 'okan@example.com', 'beklemede'],
            ['ilkokul', 'Naz', 'Doğan', 'anne', 'Pınar Doğan', '0537 555 66 77', 'pinar@example.com', 'yeni'],
        ];
        foreach ($samples as $s) {
            $level = $levels->get($s[0]);
            Application::updateOrCreate(
                ['parent_phone' => $s[5], 'student_first_name' => $s[1]],
                [
                    'level_id' => $level?->id,
                    'level_name' => $level?->name,
                    'student_first_name' => $s[1],
                    'student_last_name' => $s[2],
                    'student_birth_date' => Carbon::now()->subYears(random_int(4, 16))->subDays(random_int(0, 360)),
                    'student_gender' => random_int(0, 1) ? 'kiz' : 'erkek',
                    'parent_relation' => $s[3],
                    'parent_name' => $s[4],
                    'parent_phone' => $s[5],
                    'parent_email' => $s[6],
                    'city' => 'İstanbul',
                    'message' => 'Çocuğum için bilgi almak ve kampüsü gezmek istiyorum.',
                    'status' => $s[7],
                ]
            );
        }
    }

    private function seedContactMessages(): void
    {
        ContactMessage::updateOrCreate(
            ['email' => 'veli@example.com'],
            [
                'name' => 'Selin Korkmaz',
                'phone' => '0532 987 65 43',
                'subject' => 'Servis güzergahları hakkında',
                'message' => 'Merhaba, Ataşehir bölgesi için okul servis güzergahları hakkında bilgi alabilir miyim?',
                'is_read' => false,
            ]
        );
    }
}
