<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FindController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\OutboundController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

    Route::get('/group', [GroupController::class, 'index'])->name('group');
    Route::get('/group/add', [GroupController::class, 'add'])->name('group.add');
    Route::post('/group/add', [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/detail{id}', [GroupController::class, 'detail'])->name('group.detail');
    Route::post('/group/detail{id}', [GroupController::class, 'edit'])->name('group.edit');
    Route::post('/group/detail', [GroupController::class, 'storeDetail'])->name('group.detail.store');
    Route::get('/group/detail{id}/delete{idgrupitem}', [GroupController::class, 'deleteDetail'])->name('group.detail.delete');
    Route::get('/group/delete{id}', [GroupController::class, 'delete'])->name('group.delete');

    Route::get('/outbound', [OutboundController::class, 'index'])->name('outbound');
    Route::post('/outbound', [OutboundController::class, 'add'])->name('outbound.add');

    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/delete{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('/user/edit-password/{id}', [UserController::class, 'editPassword'])->name('user.editPassword');


    Route::get('/find', [FindController::class, 'index'])->name('find');
    Route::post('/find', [FindController::class, 'upload'])->name('find.upload');
    Route::get('/find/delete{id}', [FindController::class, 'delete'])->name('find.delete');
    Route::get('/find/print', [FindController::class, 'print'])->name('find.print');
    Route::get('/find/eksport', [FindController::class, 'eksport'])->name('find.eksport');
    Route::get('/note/{id}/{note_id}', [FindController::class, 'deleteNote'])->name('note.delete');

    Route::get('/role', [RoleController::class, 'index'])->name('role');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/delete{id}', [RoleController::class, 'destroy'])->name('role.delete');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
