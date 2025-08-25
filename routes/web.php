<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CityController,
    CommentController,
    CountryController,
    HomeController,
    PostController,
    ProfileController,
    RoleController,
    SocietyController,
    StateController,
    UserController,
    ServiceProviderController,
    ProductController
};
use App\Http\Controllers\Admin\{
    ContactController,
    ServiceProviderController as AdminServiceProviderController,
    PostController as AdminPostController,
    ServiceProviderTypeController,
    ProductCategoryController,
    ProductController as AdminProductController,
    PostCategoryController
};

// Frontend Public
Route::get('/', fn() => view('frontend.home'))->name('home');
Route::get('/contact-us', fn() => view('frontend.contact.index'))->name('contact');
Route::get('/faq', fn() => view('frontend.faq.index'))->name('faq');

// Contact Form
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');

// Frontend Posts (Authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('posts/{post}/like', [PostController::class, 'toggle'])
        ->middleware('auth')
        ->name('posts.like');
});

// Authenticated Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Location & Admin Resources
Route::middleware('auth')->group(function () {
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('societies', SocietyController::class);
    Route::resource('service-providers', ServiceProviderController::class);
    Route::post('service-providers/{service_provider}/reviews', [ServiceProviderController::class, 'storeReview'])
        ->name('providers.reviews.store');
    // Roles users data
    Route::get('roles/users/data', [RoleController::class, 'usersData'])->name('roles.users.data');
});

// Admin Backend
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', AdminPostController::class);
    Route::resource('post-categories', PostCategoryController::class);
    Route::post('posts/{post}/status', [AdminPostController::class, 'changeStatus'])->name('posts.changeStatus');
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::resource('service-providers', AdminServiceProviderController::class)
        ->except(['create', 'show', 'edit']);
    Route::post(
        'service-providers/{service_provider}/toggle',
        [AdminServiceProviderController::class, 'toggle']
    )->name('service-providers.toggle');
    Route::resource('types', ServiceProviderTypeController::class);
    Route::resource('product-categories', ProductCategoryController::class)
        ->except(['show']);
});



// Dynamic dropdowns
Route::get('/get-states-by-country/{country_id}', [StateController::class, 'getStatesByCountry']);
Route::get('/get-cities-by-state/{state_id}', [CityController::class, 'getCitiesByState']);
Route::get('/get-societies-by-city/{city_id}', [SocietyController::class, 'getSocietiesByCity']);

require __DIR__ . '/auth.php';






// Marketplace - Frontend (members)
Route::middleware('auth')->prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('{product}', [ProductController::class, 'show'])->name('show');
    Route::get('{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('{product}', [ProductController::class, 'destroy'])->name('destroy');
    Route::post('images/{image}/remove', [ProductController::class, 'removeImage'])
        ->name('image.remove');
});


Route::middleware(['auth'])->prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/', [AdminProductController::class, 'index'])->name('index');
    Route::post('/store', [AdminProductController::class, 'store'])->name('store');
    Route::put('{product}', [AdminProductController::class, 'update'])->name('update');
    Route::delete('{product}', [AdminProductController::class, 'destroy'])->name('destroy');
});
