<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Webside\IndexController;
use App\Http\Controllers\Webside\CategoryController as WebsideCategoryController;
use App\Http\Controllers\Webside\PostController as WebsidePostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Auth;


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
//webside

Route::get('/',[IndexController::class ,'index'])->name('index');
Route::get('/category/{category}',[WebsideCategoryController::class ,'show'])->name('categories');
Route::get('/posts/{post}',[WebsidePostController::class ,'show'])->name('post');










//dashboard
Route::group(['prefix' => 'dashboard','as'=>'dashboard.','middleware'=>['auth','checklogin']], function(){
        Route::get('/', function () {
            return view('dashboard.layouts.layout');
        })->name('settings');

        Route::get('/settting', [SettingController::class,'index'])->name('settings');


        Route::post('/settings/update/{setting}',[SettingController::class ,'update'])->name('settings.update');

        Route::get('users/all',[UserController::class ,'getUsersDatatable'])->name('users.all');
        Route::post('users/delete',[UserController::class ,'delete'])->name('users.delete');
        
        Route::get('categories/all',[CategoryController::class ,'getcategories'])->name('categories.all');
        Route::post('categories/delete',[CategoryController::class ,'delete'])->name('categories.delete');

        Route::get('posts/all',[PostController::class ,'getposts'])->name('posts.all');
        Route::post('posts/delete',[PostController::class ,'delete'])->name('posts.delete');

        Route::resources([
            'users'=>UserController::class,
            'categories'=>CategoryController::class,
            'posts'=>PostController::class,
        ]);
});


/*Route::get('dashboard', function () {
 return view('dashboard.settings');
})->name('dashboard.setting'); 
*/

Auth::routes();
Route::get('/home',[App\Http\Controllers\HomeController::class,'index'])->name('home');

