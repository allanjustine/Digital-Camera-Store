<?php

use App\Http\Controllers\NormalView\IndexController;
use App\Http\Controllers\NormalView\CartController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthIndexController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TestEnrollmentController;
use App\Http\Controllers\PageController;
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

Route::get('/contact-us', [PageController::class, 'contact']);
Route::put('/contact-us', [PageController::class, 'sendFeedback'])->name('feedback');
Route::get('/', [IndexController::class, 'productList'])->name('carts');
Route::get('/results/search', [IndexController::class, 'searchProduct'])->name('search');

Route::get('/login', [AuthIndexController::class, 'loginPage']);
Route::post('/login', [AuthIndexController::class, 'login'])->name('login');

Route::get('/register', [AuthIndexController::class, 'registerPage']);
Route::put('/register', [AuthIndexController::class, 'register'])->name('register');
Route::get('/verification/{user}/{token}', [AuthIndexController::class, 'verification']);

Route::get('/category/{category}', [IndexController::class, 'categoryList']);


Route::get('/logout', [AuthIndexController::class, 'logout']);

Route::middleware(['auth', 'verified'])->group(function () {

    //admin permission route
    Route::middleware('can:manage-all')->group(function () {
        Route::get('/admin/dashboard', [AdminIndexController::class, 'adminDashboard']);

        Route::get('/admin/users/result/search', [AdminPageController::class, 'search'])->name('admin.users.search');

        Route::get('/admin/users', [AdminPageController::class, 'userList']);
        Route::get('/admin/users/create', [AdminPageController::class, 'createUser']);
        Route::put('/admin/users/create', [AdminPageController::class, 'create'])->name('admin.user.create');
        Route::get('/admin/users/update/{user}', [AdminPageController::class, 'updateUser']);
        Route::put('/admin/users/update/{user}', [AdminPageController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/users/{user}', [AdminPageController::class, 'delete'])->name('admin.user.delete');

        Route::get('/admin/logs', [LogController::class, 'index'])->name('logs.index');

        Route::get('/admin/messages', [AdminIndexController::class, 'contacts']);

        Route::get('/admin/categories', [CategoryController::class, 'categories']);
        Route::get('/admin/categories/create', [CategoryController::class, 'createCategory']);
        Route::put('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::get('/admin/categories/update/{category}', [CategoryController::class, 'updateCategory']);
        Route::put('/admin/categories/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'delete'])->name('admin.category.delete');
        Route::get('/admin/categories/result/search', [CategoryController::class, 'searchCategory'])->name('admin.category.search');

        Route::get('/admin/products', [ProductController::class, 'index']);
        Route::get('/admin/products/create', [ProductController::class, 'createProduct']);
        Route::put('/admin/products/create', [ProductController::class, 'store'])->name('admin.products.create');
        Route::get('/admin/products/update/{product}', [ProductController::class, 'updateProduct']);
        Route::put('/admin/products/update/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{product}', [ProductController::class, 'delete'])->name('admin.products.delete');
        Route::get('/admin/products/result/search', [ProductController::class, 'searchProduct'])->name('admin.products.search');

        Route::get('/admin/orders', [OrderController::class, 'index']);
        Route::get('/admin/orders/create', [OrderController::class, 'createOrder']);
        Route::get('/admin/orders/view/{user}', [OrderController::class, 'viewOrders']);
        Route::put('/admin/orders/view/{order}', [OrderController::class, 'manageOrders'])->name('admin.orders.view.manage');
        Route::put('/admin/orders/create', [OrderController::class, 'createOrderNow'])->name('admin.orders.create');
        Route::get('/admin/orders/result/search', [OrderController::class, 'searchOrder'])->name('admin.orders.search');
    });

    //user permission route
    Route::middleware('can:customer')->group(function () {
        Route::get('/carts', [CartController::class, 'index']);
        Route::put('/', [CartController::class, 'addToCart'])->name('carts');
        Route::get('/carts/{cart}', [CartController::class, 'edit']);
        Route::put('/carts/{cart}', [CartController::class, 'update'])->name('update.cart');
        Route::delete('/carts/{cart}', [CartController::class, 'destroy'])->name('delete-cart');

        Route::get('/orders', [IndexController::class, 'orders']);
        Route::get('/confirm-order/{cart}', [IndexController::class, 'confirmOrder']);
        Route::put('/confirm-order/{product}', [IndexController::class, 'orderCreate'])->name('orders.create');
        Route::get('/confirm-order-quantity/{product}', [IndexController::class, 'confirmQuantity']);
        Route::put('/confirm-order-quantity/{product}', [IndexController::class, 'addOrderQuantity'])->name('confirm.order.quantity');
        Route::delete('/orders/{order}', [IndexController::class, 'cancelled'])->name('delete.order');
        Route::get('/orders/review/{order}', [IndexController::class, 'reviewRating']);
        Route::put('/orders/review/{order}', [IndexController::class, 'sendReviewRating'])->name('review.rating.order');
    });

    Route::get('/send-testenrollment', [TestEnrollmentController::class, 'sendTestNotification']);
});
Route::get('/sendmail', [EmailController::class, 'sendEmail']);
