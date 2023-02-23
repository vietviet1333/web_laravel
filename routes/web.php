<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShowProductController;

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
//homepage
route::get('/',[UserController::class,'homepage']);
route::get('/ho', [UserController::class,'ho']);


//login
route::get('/login',[UserController::class,'login']);
route::get('/client/login',[UserController::class,'cllogin']);

//register
route::get('/register',[UserController::class,'register']);
route::get('/client/register',[UserController::class,'clregister']);

//profile
route::get('/profile',[UserController::class,'profile']);
//editprofile
route::get('/editprofile/{id}',[UserController::class,'editprofile']);
route::get('/save',[UserController::class,'save']);


//send mail
route::get('/sendemail',[UserController::class,'sendemail']);
//newpass
route::get('/newpass/{email}/{oldpass}',[UserController::class,'newpass']);
route::get('/savepass/{phong}',[UserController::class,'savepass']);
//logout
route::get('/logout',[UserController::class,'logout']);
// show product
route::get('/allproduct',[ShowProductController::class,'allproduct']);
route::get('/jordan',[ShowProductController::class,'jordan']);
route::get('/nike',[ShowProductController::class,'nike']);
route::get('/adidas',[ShowProductController::class,'adidas']);
route::get('/newbalance',[ShowProductController::class,'newbalance']);
route::get('/balenciaga',[ShowProductController::class,'balenciaga']);
route::get('/mlb',[ShowProductController::class,'mlb']);
route::get('/hdmuahang',[UserController::class,'hdmuahang']);
route::get('/csdoitra',[UserController::class,'csdoitra']);
route::get('/show/{id}',[ShowProductController::class,'xemchitiet']);
route::get('/sale',[UserController::class,'sale']);
route::get('/lienhe',[UserController::class,'lienhe']);
route::get('/gioithieu',[UserController::class,'gioithieu']);
route::get('/cart',[UserController::class,'cart']);
route::get('/addcart/{id}',[UserController::class,'addcart']);
route::get('/deletepro/{id}',[UserController::class,'deletepro']);
route::get('/deletelist/{id}',[UserController::class,'deletelist']);
//Search
route::get('/search/product',[SearchController::class,'searchclient']);

//paypal
Route::get('/PurchaseHistory',[OrderController::class, 'PurchaseHistory']);
Route::get('/PurchaseHistorys',[OrderController::class, 'PurchaseHistorys']);
Route::get('/category/buy/{id}',[OrderController::class, 'categoryBuy']);

//ADMIN
Route::get('/admin/login',[AdminController::class,'login']);
Route::post('/admin/check',[AdminController::class,'check_login']);
Route::get('/admin', [AdminController::class, 'dashboard']);
Route::get('/admin/logout',[AdminController::class,'logout']);
//contact
Route::get('/contact',[ContactController::class,'create']);
Route::get('/client/contact',[ContactController::class, 'index']);


route::get('/dashboard',[AdminController::class,'dashboard']);
Route::get('/admin/user-management',[AdminController::class, 'usermanagement']);


route::get('/admin/product/delete',[ProductController::class,'productDelete']);
Route::get('/admin/delete-product/{ID_product}', [ProductController::class, 'destroy']);
Route::get('/admin/edit-product/{ID_product}', [ProductController::class, 'edit']);
Route::get('/admin/update-product', [ProductController::class, 'update']);

Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('ckfinder_connector');
    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('ckfinder_browser');

 Route::get('/admin/delete-category/{ID_category}', [CategoryController::class, 'destroy']);
 Route::get('/admin/edit-category/{ID_category}', [CategoryController::class, 'edit']);
 Route::get('/admin/update-category/{ID_category}', [CategoryController::class, 'update']);
 Route::get('/admin/category/{Name}', [ProductController::class, 'category']);


  
    Route::get('/admin/edit-profile', [AdminController::class, 'editProfile']);
    Route::get('/admin/update', [AdminController::class, 'updateProfile']);
    Route::get('/admin/search/user',[SearchController::class,'adminSearchUser']);

   
    Route::get('/admin/user-management',[AdminController::class, 'usermanagement']);
    Route::get('/admin/post_management',[ProductController::class, 'post']);
  


    //insert category
    Route::get('/admin/insert-category', [CategoryController::class, 'create']);
    Route::post('/admin/add-category', [CategoryController::class, 'store']);
    Route::get('/admin/category', [CategoryController::class, 'index']);

    // insert product
    Route::get('/admin/insert-product', [ProductController::class, 'create']);
    Route::post('/admin/add-product', [ProductController::class, 'store']);
    Route::get('/admin/product', [ProductController::class, 'index']);



    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('ckfinder_connector');
    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('ckfinder_browser');
 //seach
    Route::get('/admin/product/search',[SearchController::class,'searchProduct']);
    Route::get('/admin/order/search',[SearchController::class,'a']);
    Route::get('/admin/search/user',[SearchController::class,'adminSearchUser']);
    Route::post('/ajLogin',[SearchController::class,"ajaxLogin"]);
