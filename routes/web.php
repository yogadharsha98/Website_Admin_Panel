<?php

use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OptionsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Livewire\Admin\Slider\Index as SliderIndex;
use App\Http\Controllers\Admin\CustomFieldsController;
use App\Livewire\Admin\Category\Index as CategoryIndex;
use App\Http\Controllers\Admin\WebsiteSettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Admin\SubCategory\Index as SubCategoryIndex;
use App\Http\Controllers\Admin\CustomFieldsCategoryController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');

// Route::get('/admin', function () {
//     return redirect()->route('login');
// });

Route::get('/', [LoginController::class, 'showLoginForm'])->name('auth.login');

// Authentication routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Home route
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Load authentication routes
require __DIR__ . '/auth.php';

// Admin routes
Route::group(['middleware' => ['auth', 'role:super-admin|admin']], function () {

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

    // Admin category and sub-category routes
    Route::prefix('admin')->group(function () {

        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/category', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/category/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

        Route::get('/sub-category', SubCategoryIndex::class)->name('sub-category.index'); // Route for SubCategory

        Route::get('/slider', [SliderController::class, 'index'])->name('admin.slider.index');
        Route::get('/slider/create', [SliderController::class, 'create'])->name('admin.slider.create');
        Route::post('/slider', [SliderController::class, 'store'])->name('admin.slider.store');
        Route::get('/slider/{slider}/edit', [SliderController::class, 'edit'])->name('admin.slider.edit');
        Route::put('/slider/{slider}', [SliderController::class, 'update'])->name('admin.slider.update');
        Route::delete('/slider/{slider}', [SliderController::class, 'destroy'])->name('admin.slider.destroy');


        Route::get('/product', [ProductController::class, 'index'])->name('admin.product.index'); //Route for Products
        // Fetch subcategories by category ID
        Route::get('/get-subcategories/{category}', [ProductController::class, 'getSubcategories'])->name('admin.get-subcategories');
        Route::get('/get-fields/{category}/{subcategory}', [ProductController::class, 'getFieldsByCategorySubcategory']);
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::delete('/product-image/{id}', [ProductController::class, 'imagedestroy'])->name('admin.product-image.destroy');


        Route::get('/website_settings', [WebsiteSettingsController::class, 'index'])->name('admin.website_settings.index');
        Route::post('/website_settings', [WebsiteSettingsController::class, 'store'])->name('admin.website_settings.store');

        Route::get('/custom-field', [CustomFieldsController::class, 'index'])->name('admin.custom-field.index');
        Route::put('custom-field/{field_id}/update-status', [CustomFieldsController::class, 'updateStatus'])
            ->name('custom-field.update-status');
        Route::get('/custom-field/create', [CustomFieldsController::class, 'create'])->name('admin.custom-field.create');
        Route::post('/custom-field', [CustomFieldsController::class, 'store'])->name('admin.custom-field.store');
        Route::get('custom-field/{field}/edit', [CustomFieldsController::class, 'edit']);
        Route::put('/custom-field/{id}', [CustomFieldsController::class, 'update'])->name('custom-field.update');
        Route::delete('/custom-field/{id}', [CustomFieldsController::class, 'destroy'])->name('custom-field.destroy');

        Route::get('custom_fields/{field}/categories/create', [CustomFieldsCategoryController::class, 'create'])->name('custom_fields.categories.create');
        Route::post('/category-field/{field}/store', [CustomFieldsCategoryController::class, 'store'])->name('category-field.store');
        Route::get('admin/category-fields/{categoryField}/edit', [CustomFieldsCategoryController::class, 'edit'])->name('category-field.edit');
        // Delete Route
        Route::delete('admin/category-fields/{categoryField}', [CustomFieldsCategoryController::class, 'destroy'])->name('category-field.delete');
        Route::put('custom-field-categories/{field}', [CustomFieldsCategoryController::class, 'update'])->name('admin.custom-field-categories.update');

        Route::get('custom_fields/{field_id}/options', [OptionsController::class, 'index'])
            ->name('admin.options.index');

        Route::get('admin/custom_fields/{field_id}/options/create', [OptionsController::class, 'create'])
            ->name('admin.options.create');
        Route::post('admin/custom_fields/{field_id}/options', [OptionsController::class, 'store'])
            ->name('admin.options.store');
        // Edit route
        Route::get('admin/custom_fields/{field_id}/options/{option_id}/edit', [OptionsController::class, 'edit'])
            ->name('admin.options.edit');
        // Update route
        Route::put('admin/custom_fields/{field_id}/options/{option_id}', [OptionsController::class, 'update'])
            ->name('admin.options.update');
        // Delete route
        Route::delete('admin/custom_fields/{field_id}/options/{option_id}', [OptionsController::class, 'destroy'])
            ->name('admin.options.destroy');

        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');
        Route::post('/customer/{id}/update-status', [CustomerController::class, 'updateStatus']);
        Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    });

});
