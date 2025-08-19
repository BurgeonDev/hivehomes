<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CityController,
    CountryController,
    HomeController,
    PostController,
    ProfileController,
    RoleController,
    SocietyController,
    StateController,
    UserController
};
use App\Http\Controllers\Admin\ContactController;

// Frontend Home
Route::get('/', fn() => view('frontend.home'))->name('home');
Route::get('/contact-us', fn() => view('frontend.contact.index'))->name('contact');
Route::get('/faq', fn() => view('frontend.faq.index'))->name('faq');

// Authenticated Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Location Resources (Authenticated)
Route::middleware('auth')->group(function () {
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('societies', SocietyController::class);
});

// Dynamic Dropdown Endpoints
Route::get('/get-cities-by-state/{state_id}', [CityController::class, 'getCitiesByState']);
Route::get('/get-states-by-country/{country_id}', [StateController::class, 'getStatesByCountry']);
Route::get('/get-societies-by-city/{city_id}', [SocietyController::class, 'getSocietiesByCity']);

Route::get('roles/users/data', [RoleController::class, 'usersData'])->name('roles.users.data');

// Contact Form (Frontend User)
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');
Route::get('/posts/{id}', [HomeController::class, 'show'])->name('posts.show');

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Posts
    Route::resource('posts', PostController::class);
    Route::post('posts/{post}/status', [PostController::class, 'changeStatus'])->name('posts.changeStatus');

    // Contact Management
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
});

// Auth Routes
require __DIR__ . '/auth.php';
