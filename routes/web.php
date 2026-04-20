<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use Illuminate\Support\Facades\Crypt;

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

// Allow /admin (or /admin/) to redirect to login form if user hits just /admin
Route::redirect('/admin', '/admin/login');
Route::redirect('/admin/', '/admin/login');
route::redirect('/login', '/admin/login');

Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'loginSubmit'])->name('admin.login.submit')->middleware('throttle:5,1');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Basic admin user CRUD (not protected, consider protection if not desired)
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
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Use encrypted ID for viewing blog, handled by BlogController@show which will decrypt internally
    Route::get('/blogs/view/{id}', function ($id) {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(BlogController::class)->show($id);
    })->name('blogs.view');

    // Edit (same blade as create), with encrypted id handling for consistency
    Route::get('/blogs/edit/{id}', function ($id) {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(BlogController::class)->edit($id);
    })->name('blogs.edit');

    Route::post('/blogs/store', [BlogController::class, 'store'])->name('blogs.store');

    Route::post('/blogs/update/{id}', function (\Illuminate\Http\Request $request, $id) {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(BlogController::class)->update($request, $id);
    })->name('blogs.update');

    Route::delete('/blogs/delete/{id}', function ($id) {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid blog id');
        }
        $blog = \App\Models\Blog::findOrFail($decryptedId);
        return app(BlogController::class)->delete($id);
    })->name('blogs.delete');

    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.uploadImage');
    // Handle image download from URL for blog image upload (AJAX from admin blog create page)
    Route::post('blogs/image-from-url', [BlogController::class, 'imageFromUrl'])->name('blogs.imageFromUrl');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');

    Route::resource('menus', MenuController::class)->names('menus');
    Route::resource('menu-items', MenuItemController::class)->names('menu-items');
    Route::get('preview/navbar-tree', [MenuController::class, 'treePreview'])->name('preview.navbar');
    Route::get('menu-items/form', [MenuItemController::class, 'form'])->name('menu-items.form');
});

use Illuminate\Http\Request;

Route::post('/admin/import/fetch-html', function (Request $request) {
    $url = $request->input('url');
    if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
        return response()->json(['html' => null, 'error' => 'Invalid or missing URL.'], 400);
    }
    try {
        $html = file_get_contents($url);
        return response()->json(['html' => $html]);
    } catch (\Exception $e) {
        return response()->json(['html' => null, 'error' => 'Unable to fetch content.'], 500);
    }
});


// PUBLIC BLOG LIST AND BLOG VIEW
Route::get('/blogs', [BlogController::class, 'publicBlogs']);
// Route now uses the blog title as a slug for display, but internally uses the id for lookup
Route::get('/blogs_view/{id}-{title}', [BlogController::class, 'view'])
    ->where(['id' => '[0-9]+', 'title' => '[A-Za-z0-9\-]+']);

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (EXISTING PROJECT)
|--------------------------------------------------------------------------
*/
// Uncomment or update as needed for your project:
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
// This route should come last so that it only matches when no other route does.
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
