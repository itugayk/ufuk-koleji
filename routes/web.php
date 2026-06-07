<?php

use App\Http\Controllers\PageController;
use App\Livewire\ApplicationForm;
use App\Livewire\ContactForm;
use App\Livewire\NewsIndex;
use App\Livewire\NewsShow;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/kurumsal', [PageController::class, 'about'])->name('kurumsal');
Route::get('/kademeler', [PageController::class, 'levels'])->name('kademeler');
Route::get('/kademeler/{level}', [PageController::class, 'levelShow'])->name('kademe');
Route::get('/egitim-modeli', [PageController::class, 'educationModel'])->name('egitim-modeli');
Route::get('/kampus', [PageController::class, 'campus'])->name('kampus');
Route::get('/basarilarimiz', [PageController::class, 'achievements'])->name('basarilarimiz');

Route::get('/haberler', NewsIndex::class)->name('haberler');
Route::get('/haberler/{slug}', NewsShow::class)->name('haber');

Route::get('/kayit', ApplicationForm::class)->name('kayit');
Route::get('/iletisim', ContactForm::class)->name('iletisim');
