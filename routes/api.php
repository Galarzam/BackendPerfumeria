<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JWTController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Product\CategorieController;
use App\Http\Controllers\Product\ProductGController;  
use App\Http\Controllers\Product\ProductImagensController;  
use App\Http\Controllers\Slider\SliderController;
use App\Http\Controllers\Cupones\CuponesController;  
use App\Http\Controllers\Discount\DiscountController; 

use App\Http\Controllers\Sales\SalesController;


use App\Http\Controllers\Ecommerce\HomeController; 
use App\Http\Controllers\Ecommerce\Cart\CartShopController;
use App\Http\Controllers\Ecommerce\Client\AddressUserController;
use App\Http\Controllers\Ecommerce\Sale\SaleController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});




    Route::group(['prefix' => 'users'], function($router) {
        Route::post('/register', [JWTController::class, 'register']);
        Route::post('/login', [JWTController::class, 'loginAdmin']);
        Route::post('/login_ecommerce', [JWTController::class, 'loginClient']);
        Route::post('/logout', [JWTController::class, 'logout']);
        Route::post('/refresh', [JWTController::class, 'refresh']);
        Route::post('/profile', [JWTController::class, 'profile']); 
    
        Route::group(['prefix' => 'admin'], function() {
            Route::get('/all', [UserController::class, 'index']);
            Route::post('/register', [UserController::class, 'store']);
            Route::put('/update/{id}', [UserController::class, 'update']);
            Route::delete('/delete/{id}', [UserController::class, 'destroy']);
        });
    });
    
    Route::group(['prefix' => 'products'], function($router) {
    
        Route::get("/get_info", [ProductGController::class, 'get_info']);
        Route::post("/add", [ProductGController::class, 'store']); 
        Route::post("/update/{id}",[ProductGController::class, 'update']);
        Route::get("/all", [ProductGController::class, 'index']);
        Route::get("/show_product/{id}", [ProductGController::class, 'show']);
        
        Route::group(["prefix" => "imgs"],function() {
            Route::post("/add",[ProductImagensController::class, 'store']);  
            Route::delete("/delete/{id}",[ProductImagensController::class, 'destroy']);
        });
    
        Route::group(['prefix' => 'categories'], function() {
            Route::get("/all", [CategorieController::class, 'index']);
            Route::post("/add", [CategorieController::class, 'store']);
            Route::post("/update/{id}", [CategorieController::class, 'update']);
            Route::delete("/delete/{id}", [CategorieController::class, 'destroy']);
        });
    });
    
    Route::group(['prefix' => 'sliders'], function($router) {
        Route::get("/all",[SliderController::class, 'index']);
        Route::post("/add",[SliderController::class, 'store']);   
        Route::post("/update/{id}",[SliderController::class, 'update']);   
        Route::delete("/delete/{id}",[SliderController::class, 'destroy']);   
    });
    
    Route::group(['prefix' => 'cupones'], function($router) {
        Route::get("/all",[CuponesController::class, 'index']);    
        Route::get("/config_all",[CuponesController::class, 'config_all']);
        Route::get("/show/{id}",[CuponesController::class, 'show']);
        Route::post("/add",[CuponesController::class, 'store']);       
        Route::post("/update/{id}",[CuponesController::class, 'update']);       
        Route::delete("/delete/{id}",[CuponesController::class, 'destroy']);       
    });
    
    Route::group(['prefix' => 'descuentos'], function($router) {
        Route::get("/all", [DiscountController::class, 'index']);           
        Route::get("/show/{id}", [DiscountController::class, 'show']);  
        Route::post("/add",[DiscountController::class, 'store']);     
        Route::put("/update/{id}",[DiscountController::class, 'update']);     
        Route::delete("/delete/{id}",[DiscountController::class, 'destroy']);     
    });

    //Listado de las Ordenes 
        Route::post("/sales/all", [SalesController::class, 'sale_all']); 
    
   
    //Route::get("/sale_mail/{id}",[SaleController::class, 'send_email']); 
    
    Route::group(['prefix' => 'ecommerce'], function($router) {
        Route::get("/home", [HomeController::class, 'home']);           
        Route::get("/detail-product/{slug}", [HomeController::class, 'detail_product']);  
        //Listado de Productos   
        Route::post("/list-products", [HomeController::class, 'list_product']);  
        Route::get("/config_initial_filter", [HomeController::class, 'config_initial_filter']); 

        Route::group(["prefix" => "cart"], function () {
            Route::get("/all", [CartShopController::class, 'index']);  
            Route::post("/add",[CartShopController::class, 'store']); 
            Route::put("/update/{id}",[CartShopController::class, 'update']); 
            Route::delete("/delete/{id}",[CartShopController::class, 'destroy']); 
            //Ruta del Cupon
            Route::get("/applycupon/{cupon}", [CartShopController::class, 'apply_cupon']); 
           
        });

        Route::group(["prefix" => "checkout"], function () {
            Route::get("/all", [AddressUserController::class, 'index']);  
            Route::post("/add",[AddressUserController::class, 'store']); 
            Route::put("/update/{id}",[AddressUserController::class, 'update']); 
            Route::delete("/delete/{id}",[AddressUserController::class, 'destroy']); 
              //Proceso de pago
            Route::post("/sale",[SaleController::class, 'store']); 
        });

           
    });

    


