<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Admin\TicketController;
use App\Http\Controllers\Web\WidgetController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    // Редирект админов и менеджеров в админку
    if ($user && $user->hasAnyRole(['admin', 'manager'])) {
        return redirect()->route('admin.tickets.index');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth', 'role:manager|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
});

Route::get('widget', [WidgetController::class, 'index'])->name('widget.index');
