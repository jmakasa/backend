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
/*

Route::get('/', function () {
    Log::debug("route");
    return view('welcome');
});
Route::get('/{locale}',function () {  
    Log::debug($locale);
    return view('welcome');
});
*/

Auth::routes();

Route::post('/switch_lang', 'HomeController@switchLang')->name('switch-lang');
Route::get('/migrate/products', 'MigrateController@doProducts')->name('doProducts');

Route::prefix('{locale}')
    ->middleware(['set_locale'])
    ->group(
        function ($locale) {

            Route::get('/home', 'HomeController@index')->name('home');
            Route::get('/', 'HomeController@landing')->name('home.landing');
            Route::get('/aboutus', 'HomeController@aboutus')->name('home.aboutus');
        }
    );

// admin 
Route::prefix('{locale}/admin')
    ->middleware(['set_locale'])
    ->group(
        function ($locale) {
        Route::get('/category', 'CategoryController@index')->name('admin.category_list');
        });

Route::prefix('{locale}/admin')
    ->middleware(['set_locale'])
    ->group(
        function ($locale) {
            // home
            Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

            // category
            //Route::get('/category', 'CategoryController@index')->name('admin.category_list');
            Route::get('/category', 'CategoryController@index')->name('admin.category_list');
            Route::get('/category/create', 'CategoryController@create')->name('admin.category_create');
            Route::get('/category/edit/{category_id}', 'CategoryController@edit')->name('admin.category_edit');
            Route::post('/category/store', 'CategoryController@store')->name('admin.category_store');
            Route::post('/category/update', 'CategoryController@update')->name('admin.category_update');

            // Keywords
            Route::get('/keywords', 'KeywordsController@index')->name('admin.keywords_list');
            Route::get('/keywords/create', 'KeywordsController@create')->name('admin.keywords_create');
            Route::get('/keywords/edit/{keywords_id}', 'KeywordsController@edit')->name('admin.keywords_edit');
            Route::post('/keywords/store', 'KeywordsController@store')->name('admin.keywords_store');
            Route::post('/keywords/update', 'KeywordsController@update')->name('admin.keywords_update');


            // Tags
            Route::get('/tags', 'TagsController@index')->name('admin.tags_list');
            Route::get('/tags/create', 'TagsController@create')->name('admin.tags_create');
            Route::get('/tags/edit/{tags_id}', 'TagsController@edit')->name('admin.tags_edit');
            Route::post('/tags/store', 'TagsController@store')->name('admin.tags_store');
            Route::post('/tags/update', 'TagsController@update')->name('admin.tags_update');
           
            // Product
            Route::get('/products', 'ProductsController@index')->name('admin.products_list');
            Route::get('/products/create', 'ProductsController@create')->name('admin.products_create');
            Route::get('/products/edit/{products_id}', 'ProductsController@edit')->name('admin.products_edit');
            Route::post('/products/store', 'ProductsController@store')->name('admin.products_store');
            Route::post('/products/update', 'ProductsController@update')->name('admin.products_update');
        }
    );

Route::get('/', function () {
    return redirect()->to('/' . config("app.locale"));
});
