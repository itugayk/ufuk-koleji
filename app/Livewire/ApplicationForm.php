<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Level;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Kayıt Başvurusu')]
class ApplicationForm extends Component
{
    public int $step = 1;

    public bool $submitted = false;

    #[Url]
    public ?int $level_id = null;

    // Öğrenci
    public string $student_first_name = '';
    public string $student_last_name = '';
    public ?string $student_birth_date = null;
    public ?string $student_gender = null;
    public ?string $current_school = null;

    // Veli
    public string $parent_name = '';
    public ?string $parent_relation = null;
    public string $parent_phone = '';
    public ?string $parent_email = null;
    public ?string $city = null;
    public ?string $address = null;
    public ?string $message = null;

    public bool $consent = false;

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => ['level_id' => ['required', 'exists:levels,id']],
            2 => [
                'student_first_name' => ['required', 'string', 'max:255'],
                'student_last_name' => ['required', 'string', 'max:255'],
                'student_birth_date' => ['nullable', 'date'],
                'student_gender' => ['nullable', 'in:kiz,erkek'],
            ],
            3 => [
                'parent_name' => ['required', 'string', 'max:255'],
                'parent_relation' => ['nullable', 'in:anne,baba,vasi'],
                'parent_phone' => ['required', 'string', 'max:30'],
                'parent_email' => ['nullable', 'email'],
                'consent' => ['accepted'],
            ],
            default => [],
        };
    }

    protected function messages(): array
    {
        return [
            'level_id.required' => 'Lütfen bir kademe seçin.',
            'consent.accepted' => 'Devam etmek için aydınlatma metnini onaylamanız gerekir.',
            'required' => 'Bu alan zorunludur.',
        ];
    }

    public function selectLevel(int $id): void
    {
        $this->level_id = $id;
        $this->nextStep();
    }

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step));
        $this->step = min($this->step + 1, 4);
    }

    public function prevStep(): void
    {
        $this->step = max($this->step - 1, 1);
    }

    public function submit(): void
    {
        $this->validate($this->rulesForStep(3));

        $level = Level::find($this->level_id);

        Application::create([
            'level_id' => $level?->id,
            'level_name' => $level?->name,
            'student_first_name' => $this->student_first_name,
            'student_last_name' => $this->student_last_name,
            'student_birth_date' => $this->student_birth_date,
            'student_gender' => $this->student_gender,
            'current_school' => $this->current_school,
            'parent_name' => $this->parent_name,
            'parent_relation' => $this->parent_relation,
            'parent_phone' => $this->parent_phone,
            'parent_email' => $this->parent_email,
            'city' => $this->city,
            'address' => $this->address,
            'message' => $this->message,
            'status' => 'yeni',
        ]);

        $this->submitted = true;
    }

    public function getSelectedLevelProperty(): ?Level
    {
        return $this->level_id ? Level::find($this->level_id) : null;
    }

    public function render()
    {
        return view('livewire.application-form', [
            'levels' => Level::active()->get(),
        ])->layout('components.layouts.app');
    }
}
