<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

//Главная страница
Route::get('/', function () {
    return view('home');
})->name('home');

//Редирект /home на главную
Route::get('/home', function () {
    return redirect('/');
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage linked!';
});

Route::get('/check-images', function () {
    $products = App\Models\Product::with('images')->get();
    $output = '';
    foreach ($products as $product) {
        $output .= '<h3>' . $product->name . '</h3>';
        foreach ($product->images as $img) {
            $path = storage_path('app/public/' . $img->image);
            $exists = file_exists($path);
            $output .= 'Файл: ' . $img->image . ' - существует: ' . ($exists ? 'Да' : 'Нет') . '<br>';
        }
    }
    return $output;
});

//Маршруты каталога
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
// Route::get('/catalog', function () {
//     $categories = App\Models\Category::all();
//     return view('catalog', ['categories' => $categories]);
// });
Route::get('/catalog/{slug}', [CatalogController::class, 'category'])->name('category');
Route::get('/catalog/{categorySlug}/{productSlug}', [CatalogController::class, 'product'])->name('product');

//Статические страницы
Route::get('/news', function () {
    return view('news');
})->name('news');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/debug-categories', function () {
    $categories = App\Models\Category::all();
    $output = '<h1>Categories:</h1>';
    foreach ($categories as $cat) {
        $output .= $cat->id . ' - ' . $cat->name . '<br>';
    }
    return $output;
});

//Новости
Route::get('/news/{slug}', function ($slug) {
    $news = App\Models\News::where('slug', $slug)->where('is_active', true)->firstOrFail();
    return view('news.show', compact('news'));
})->name('news.show');

//Маршруты корзины
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

//AJAX маршруты для корзины
Route::post('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.update-all');
Route::post('/cart/remove-all', [CartController::class, 'removeItem'])->name('cart.remove-all');
Route::post('/cart/clear-all', [CartController::class, 'clearAll'])->name('cart.clear-all');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

//Админские маршруты
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [AdminController::class, 'index'])->name('index');
    
    //Категории
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/active', [CategoryController::class, 'indexActive'])->name('categories.active');
    Route::get('/categories/archived', [CategoryController::class, 'indexArchived'])->name('categories.archived');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}/archive', [CategoryController::class, 'archive'])->name('categories.archive');
    Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    //Товары
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/active', [ProductController::class, 'indexActive'])->name('products.active');
    Route::get('/products/archived', [ProductController::class, 'indexArchived'])->name('products.archived');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}/archive', [ProductController::class, 'archive'])->name('products.archive');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/image/{id}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
    Route::post('/products/image/sort', [ProductController::class, 'sortImages'])->name('products.image.sort');
    
    //Пользователи
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/make-admin', [UserController::class, 'makeAdmin'])->name('users.make-admin');
    Route::post('/users/{id}/remove-admin', [UserController::class, 'removeAdmin'])->name('users.remove-admin');
    
    //Заказы
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    //Новости
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/active', [NewsController::class, 'indexActive'])->name('news.active');
    Route::get('/news/archived', [NewsController::class, 'indexArchived'])->name('news.archived');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{id}/archive', [NewsController::class, 'archive'])->name('news.archive');
    Route::post('/news/{id}/restore', [NewsController::class, 'restore'])->name('news.restore');
    Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::delete('/news/image/{id}', [NewsController::class, 'deleteImage'])->name('news.image.delete');
    Route::post('/news/image/sort', [NewsController::class, 'sortImages'])->name('news.image.sort');
});

//Публичные маршруты заказов
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('cart.success');

//Аутентификация
Auth::routes();