<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kayıt / başvuru kayıtları
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->string('level_name')->nullable();
            // Öğrenci
            $table->string('student_first_name');
            $table->string('student_last_name');
            $table->date('student_birth_date')->nullable();
            $table->string('student_gender')->nullable();
            $table->string('current_school')->nullable();
            // Veli
            $table->string('parent_name');
            $table->string('parent_relation')->nullable(); // anne | baba | vasi
            $table->string('parent_phone');
            $table->string('parent_email')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->text('message')->nullable();
            // Yönetim
            $table->string('status')->default('yeni');  // yeni | gorusuldu | kabul | beklemede | red
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('status');
        });

        // Kampüs galerisi
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('category')->nullable();  // Kampüs | Sosyal | Spor | Sanat | Laboratuvar
            $table->string('image_path')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Başarılar (sayaçlar + başarı hikayeleri)
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('value')->nullable(); // sayaç değeri
            $table->string('suffix')->nullable();          // + , % vb.
            $table->string('icon')->nullable();
            $table->string('category')->nullable();        // Üniversite | Olimpiyat | Spor ...
            $table->unsignedSmallInteger('year')->nullable();
            $table->boolean('is_stat')->default(false);    // true => anasayfa sayacı
            $table->string('image_path')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Veli yorumları
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();   // "Veli – 7. Sınıf"
            $table->text('body');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('image_path')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // İletişim form mesajları
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // Site ayarları (key/value)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('applications');
    }
};
