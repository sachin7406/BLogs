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

// Allow /admin (or /admin/) to redirect to login form if user hits just /admin
Route::redirect('/admin', '/admin/login');
Route::redirect('/admin/', '/admin/login');

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

    // Use encrypted ID for viewing blog, handled by BlogController@show which will decrypt internally
    Route::get('/blogs/view/{id}', function ($id) {
        $encryptedId = $id;
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(\App\Http\Controllers\Admin\BlogController::class)->show($encryptedId);
    })->name('blogs.view');

    // Edit (same blade as create), with encrypted id handling for consistency
    Route::get('/blogs/edit/{id}', function ($id) {
        $encryptedId = $id;
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(\App\Http\Controllers\Admin\BlogController::class)->edit($encryptedId);
    })->name('blogs.edit');

    Route::post('/blogs/store', [BlogController::class, 'store'])->name('blogs.store');

    Route::post('/blogs/update/{id}', function ($id, \Illuminate\Http\Request $request) {
        $encryptedId = $id;
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(\App\Http\Controllers\Admin\BlogController::class)->update($request, $encryptedId);
    })->name('blogs.update');

    Route::delete('/blogs/delete/{id}', function ($id) {
        $encryptedId = $id;
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(\App\Http\Controllers\Admin\BlogController::class)->delete($encryptedId);
    })->name('blogs.delete');


    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.uploadImage');
    // Handle image download from URL for blog image upload (AJAX from admin blog create page)
    Route::post('blogs/image-from-url', [BlogController::class, 'imageFromUrl'])->name('blogs.imageFromUrl');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
});


Route::get('/blogs', [BlogController::class, 'publicBlogs']);
// Route now uses the blog title as a slug for display, but internally uses the id for lookup
Route::get('/blogs_view/{id}-{title}', [BlogController::class, 'view'])
    ->where(['id' => '[0-9]+', 'title' => '[A-Za-z0-9\-]+']);
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
