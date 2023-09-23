<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('products', \App\Livewire\Products\Home::class)->name('products') ;
    Route::get('products/link', \App\Livewire\Products\Link::class)->name('link') ;
    Route::get('config', \App\Livewire\Config\Checkout::class)->name('config.checkout') ;
    Route::get('invoices', \App\Livewire\Payment\Invoices::class)->name('invoices') ;
    Route::get('statement', \App\Livewire\Payment\Statement::class)->name('statement') ;
}) ;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';