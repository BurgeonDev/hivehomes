<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use App\Models\State;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('frontend.home');
})->name('home');


Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/societies', [SocietyController::class, 'index'])->name('societies.index');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('societies', SocietyController::class);
});

Route::get('/get-cities-by-state/{state_id}', [CityController::class, 'getCitiesByState']);
Route::get('/get-states-by-country/{country_id}', [StateController::class, 'getStatesByCountry']);
Route::get('roles/users/data', [RoleController::class, 'usersData'])->name('roles.users.data');

require __DIR__ . '/auth.php';
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::resource('posts', PostController::class);
        Route::post('posts/{post}/status', [PostController::class, 'changeStatus'])
            ->name('posts.changeStatus');
    });
