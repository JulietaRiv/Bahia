<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Site'], function () {
    Route::get('/', 'SiteController@index')->name('index');
    Route::get('/products/{criteria}/{slug_name}', 'SiteController@products')->name('siteProducts');
    Route::get('/product/{slug_name}', 'SiteController@detailProduct')->name('siteDetailProduct');
    Route::match(['get', 'post'], '/checkout', 'CartController@checkout')->name('cartCheckout');
    Route::post('/sendOrder', 'CartController@sendOrder')->name('cartSendOrder');
});    

Route::group(['prefix' => '/admin', 'middleware'=>'auth', 'namespace' => 'Admin'], function () {
    Route::get('/', 'WelcomeController@welcome')->name('welcome');    
    Route::group(['prefix' => "/products"], function() {
        Route::get('/index', "ProductsController@index")->name("products");
        Route::get('/add', "ProductsController@create")->name("productsAdd");
        Route::get('/edit/{id}', "ProductsController@edit")->name("productsEdit");
        Route::post('/store', "ProductsController@store")->name("productsStore");
        Route::post('/update', "ProductsController@update")->name("productsUpdate");
        Route::get('/detail/{id}', "ProductsController@detail")->name("productsDetail");
        Route::get('/delete/{id}', "ProductsController@delete")->name("productsDelete");
        Route::get('/highlighted', "ProductsController@highlightedProducts")->name("productsHighlighted");
        Route::get('/offer', "ProductsController@offerProducts")->name("productsOffer");
        Route::get('/offerSelected/{ids}', "ProductsController@offerSelected")->name("productsOfferSelected");
        Route::get('/highlightedSelected/{ids}', "ProductsController@highlightedSelected")->name("productsHighlightedSelected");
        Route::get('/stock', "ProductsController@stock")->name("productsStock");
        Route::get('/stockPerBrand', "ProductsController@stockPerBrand")->name("productsStockPerBrand");
        Route::get('/deleteImage/{product_id}', "ProductsController@deleteImage")->name("productsDeleteImage");
    });
    Route::group(['prefix' => "/categories"], function() {
        Route::get('/index', "CategoriesController@index")->name("categories");
        Route::get('/add', "CategoriesController@create")->name("categoriesAdd");
        Route::get('/edit/{id}', "CategoriesController@edit")->name("categoriesEdit");
        Route::post('/store', "CategoriesController@store")->name("categoriesStore");
        Route::post('/update', "CategoriesController@update")->name("categoriesUpdate");
        Route::get('/detail/{id}', "CategoriesController@detail")->name("categoriesDetail");
        Route::get('/delete/{id}', "CategoriesController@delete")->name("categoriesDelete");
    });
    Route::group(['prefix' => "/brands"], function() {
        Route::get('/index', "BrandsController@index")->name("brands");
        Route::get('/add', "BrandsController@create")->name("brandsAdd");
        Route::get('/edit/{id}', "BrandsController@edit")->name("brandsEdit");
        Route::post('/store', "BrandsController@store")->name("brandsStore");
        Route::post('/update', "BrandsController@update")->name("brandsUpdate");
        Route::get('/detail/{id}', "BrandsController@detail")->name("brandsDetail");
        Route::get('/delete/{id}', "BrandsController@delete")->name("brandsDelete");
    });
    Route::group(['prefix' => "/orders"], function() {
        Route::get('/index', "OrdersController@index")->name("orders");
        Route::get('/detail/{id}', "OrdersController@detail")->name("ordersDetail");
        Route::get('/edit/{id}', "OrdersController@edit")->name("ordersEdit");
        Route::get('/delete/{id}', "OrdersController@delete")->name("ordersDelete");
        Route::post('/update', "OrdersController@update")->name("ordersUpdate");
        Route::get('/delivery/{id}', "OrdersController@delivery")->name("ordersDeliveryStatus");
    });   
    Route::get('/subscriptions', 'PushSubscriptionController@update')->name("susbs");
    Route::post('/subscriptions/delete', 'PushSubscriptionController@destroy')->name("hola");;
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');