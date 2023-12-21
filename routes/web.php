<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductImageController;

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

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/shop/{categorySlug?}/{subcategorySlug?}', 'shop')->name('shop');
    Route::get('/product/{slug}', 'product')->name('product');
    Route::get('/category/{slug?}', 'category')->name('category');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/wishlist', 'wishlist')->name('wishlist');
    Route::get('/cart', 'cart')->name('cart');
    Route::post('/cart', 'cartadd')->name('cart.add');
    Route::delete('/cart', 'cartdelete')->name('cart.delete');
    Route::get('/checkout', 'checkout')->name('checkout');
});

Route::group(['prefix' => 'admin'], function(){
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        // Category
        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/category', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

        // Sub Category
        Route::get('/subcategory', [SubCategoryController::class, 'index'])->name('admin.subcategory');
        Route::get('/subcategory/create', [SubCategoryController::class, 'create'])->name('admin.subcategory.create');
        Route::post('/subcategory', [SubCategoryController::class, 'store'])->name('admin.subcategory.store');
        Route::get('/subcategory/{id}/edit', [SubCategoryController::class, 'edit'])->name('admin.subcategory.edit');
        Route::put('/subcategory/{id}', [SubCategoryController::class, 'update'])->name('admin.subcategory.update');
        Route::delete('/subcategory/{id}', [SubCategoryController::class, 'destroy'])->name('admin.subcategory.delete');

        // Brand
        Route::get('/brand', [BrandController::class, 'index'])->name('admin.brand');
        Route::get('/brand/create', [BrandController::class, 'create'])->name('admin.brand.create');
        Route::post('/brand', [BrandController::class, 'store'])->name('admin.brand.store');
        Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('admin.brand.edit');
        Route::put('/brand/{id}', [BrandController::class, 'update'])->name('admin.brand.update');
        Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('admin.brand.delete');

        // Product
        Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::get('/product/related', [ProductController::class, 'related'])->name('admin.product.related');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('admin.product.delete');

        // Product Image
        Route::get('/product-image/{slug}', [ProductImageController::class, 'index'])->name('admin.product.image');
        Route::post('/product-image/{slug}', [ProductImageController::class, 'store'])->name('admin.product.image.store');
        Route::delete('/product-image/{id}', [ProductImageController::class, 'destroy'])->name('admin.product.image.delete');
    });

    Route::post('/slug', function(Request $request){
        $slug = '';
        if (!empty($request->title)) {
            $slug = Str::slug($request->title);
            return response()->json([
                'status' => true,
                'slug'   => $slug,
            ]);
        }
    })->name('get.slug');
});