<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;


/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'loginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'loginSubmit'])
    ->name('admin.login.submit');

Route::get('/admin/logout', [AuthController::class, 'logout'])
    ->name('admin.logout');


Route::prefix('admin')->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
/*
|--------------------------------------------------------------------------
| ADMIN BLOG (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware('blog.auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [BlogController::class, 'dashboard'])->name('dashboard');
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::get('/blogs/view/{id}', [BlogController::class, 'show'])->name('blogs.view');
    // Route::get('/blogs/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    // Edit (same blade as create)
    Route::get('/blogs/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::post('/blogs/store', [BlogController::class, 'store'])->name('blogs.store');
    Route::post('/blogs/update/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/delete/{id}', [BlogController::class, 'delete'])->name('blogs.delete');
    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.uploadImage');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
});

// Route::get('/blogs', function () {
//     return view('pages.blogs');
// })->name('blogs.public');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (EXISTING PROJECT)
|--------------------------------------------------------------------------
*/
// Route::get('/', function () {
//     return view('pages.home');
// });

// Route::get('/spa/{path}', function ($path) {

//     $viewPath = str_replace('-', '_', $path);
//     $partial  = "partials.$viewPath";

//     if (!view()->exists($partial)) {
//         abort(404);
//     }

//     return view($partial);
// })->where('path', '.*');

// Route::get('/{path}', function ($path) {

//     $viewPath = str_replace('-', '_', $path);
//     $partial  = "partials.$viewPath";

//     if (!view()->exists($partial)) {
//         abort(404);
//     }

//     return view('pages.dynamic', compact('partial'));
// })->where('path', '.*');


Route::get('/', fn() => view('pages.home'));

/*
|--------------------------------------------------------------------------
| DYNAMIC PUBLIC PAGES (LAST)
|--------------------------------------------------------------------------
*/
Route::get('/{path}', function ($path) {

    $viewPath = str_replace('-', '_', $path);
    $partial  = "partials.$viewPath";

    if (!view()->exists($partial)) {
        abort(404);
    }

    return view('pages.dynamic', compact('partial'));
})->where('path', '.*');

Route::post('/contact-submit', [ContactController::class, 'store'])
    ->name('contact.store');
