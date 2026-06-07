<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kademeler (Anaokulu / İlkokul / Ortaokul / Lise)
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->string('age_range')->nullable();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->string('icon')->nullable();        // heroicon adı
            $table->string('color')->default('#13315c');
            $table->string('image_path')->nullable();   // seed/fallback görsel
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Haber / Duyuru kategorileri
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->default('#f5b301');
            $table->timestamps();
        });

        // Haberler & Duyurular CMS
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_category_id')->nullable()->constrained('news_categories')->nullOnDelete();
            $table->string('type')->default('haber');   // haber | duyuru
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->json('tags')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();

            $table->index(['is_published', 'published_at']);
            $table->index('type');
        });

        // Kurumsal sayfa içerikleri (vizyon, misyon, tarihçe, eğitim modeli vb.)
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();   // vizyon | misyon | tarihce | egitim-modeli ...
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        // Eğitim modeli / farkımız öğeleri (ikonlu kartlar)
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->default('#f5b301');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Etkinlik takvimi
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('starts_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('features');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_categories');
        Schema::dropIfExists('levels');
    }
};
