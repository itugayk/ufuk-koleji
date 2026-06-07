<?php

namespace Tests\Feature;

use App\Filament\Resources\ApplicationResource\Pages\ListApplications;
use App\Filament\Resources\NewsResource\Pages\ListNews;
use App\Livewire\ApplicationForm;
use App\Livewire\ContactForm;
use App\Models\Application;
use App\Models\ContactMessage;
use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_multi_step_application_creates_record(): void
    {
        $level = Level::create(['name' => 'Test Kademe', 'slug' => 'test-kademe', 'is_active' => true]);

        Livewire::test(ApplicationForm::class)
            ->call('selectLevel', $level->id)
            ->assertSet('step', 2)
            ->set('student_first_name', 'Ada')
            ->set('student_last_name', 'Yılmaz')
            ->call('nextStep')
            ->assertSet('step', 3)
            ->set('parent_name', 'Veli Yılmaz')
            ->set('parent_phone', '05551112233')
            ->set('consent', true)
            ->call('nextStep')
            ->assertSet('step', 4)
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertTrue(
            Application::where('student_first_name', 'Ada')->where('status', 'yeni')->exists()
        );
    }

    public function test_application_requires_level(): void
    {
        Livewire::test(ApplicationForm::class)
            ->call('nextStep')
            ->assertHasErrors('level_id');
    }

    public function test_contact_form_saves_message(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Selin')
            ->set('message', 'Bu bir test mesajıdır, en az on karakter.')
            ->call('submit')
            ->assertSet('sent', true);

        $this->assertTrue(ContactMessage::where('name', 'Selin')->exists());
    }

    public function test_admin_panel_pages_render(): void
    {
        $user = User::create(['name' => 'Admin', 'email' => 'a@a.com', 'password' => bcrypt('secret')]);

        $this->actingAs($user);

        $this->get('/admin')->assertOk();

        Livewire::test(ListNews::class)->assertOk();
        Livewire::test(ListApplications::class)->assertOk();
    }
}
