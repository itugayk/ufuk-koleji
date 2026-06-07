<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('İletişim')]
class ContactForm extends Component
{
    public string $name = '';
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $subject = null;
    public string $message = '';

    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Lütfen adınızı girin.',
            'message.required' => 'Lütfen mesajınızı yazın.',
            'message.min' => 'Mesaj en az 10 karakter olmalıdır.',
            'email.email' => 'Geçerli bir e-posta girin.',
        ];
    }

    public function submit(): void
    {
        $data = $this->validate();

        ContactMessage::create($data);

        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.contact-form')->layout('components.layouts.app');
    }
}
