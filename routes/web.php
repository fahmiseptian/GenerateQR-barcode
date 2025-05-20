<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FindController;
use App\Http\Controllers\OutboundController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
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
    return redirect('/login');
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache, config, route, and view cleared!";
});

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    Artisan::call('optimize');
    return "Application optimized!";
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return "Storage linked!";
});

Route::get('/find/detail{id}', [FindController::class, 'detail'])->name('find.detail');
Route::get('/note/{id}', [FindController::class, 'note'])->name('note');
Route::post('/note/{id}', [FindController::class, 'addNote'])->name('note.add');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/outbound', function () {
//     return view('outbound');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/outbound', [OutboundController::class, 'index'])->name('outbound');
    Route::post('/outbound', [OutboundController::class, 'add'])->name('outbound.add');

    Route::get('/find', [FindController::class, 'index'])->name('find');
    Route::get('/find/delete{id}', [FindController::class, 'delete'])->name('find.delete');
    Route::get('/find/print', [FindController::class, 'print'])->name('find.print');
    Route::get('/find/eksport', [FindController::class, 'eksport'])->name('find.eksport');
    Route::get('/note/{id}/{note_id}', [FindController::class, 'deleteNote'])->name('note.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
