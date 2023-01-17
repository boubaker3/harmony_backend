<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UserdataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RestaurentsController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ChefShipperController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/reviews",[ReviewsController::class,"post"]);
Route::post("/updatePicture",[RegistrationController::class,"updatePicture"]);
Route::get("/userdata ",[UserdataController::class,"getUserdata"]);
Route::post("/signup",[RegistrationController::class,"signup"]);
Route::post("/login ",[AuthController::class,"login"]);
Route::post("/addProduct ",[ProductsController::class,"saveProduct"]);
Route::get("/retrieveProducts ",[ProductsController::class,"retrieveProducts"]);
Route::get("/retrieveProductDetails ",[ProductsController::class,"retrieveProductDetails"]);
Route::post("/saveFeedbacks ",[NotificationsController::class,"saveFeedbacks"]);
Route::get("/retrieveFeedbacks ",[NotificationsController::class,"retrieveFeedbacks"]);
Route::get("/retrieveRestaurents ",[RestaurentsController::class,"retrieveRestaurents"]);
Route::get("/retrieveRestaurents ",[RestaurentsController::class,"retrieveRestaurents"]);
Route::post("/sendRating ",[NotificationsController::class,"sendRating"]);
Route::post("/updateProfile ",[UserdataController::class,"updateProfile"]);
Route::post("/sendMsg ",[ChatController::class,"sendMsg"]);
Route::get("/retrieveMsgs ",[ChatController::class,"retrieveMsgs"]);
Route::get("/retrieveMessagedUsers ",[ChatController::class,"retrieveMessagedUsers"]);
Route::get("/searchForRestaurents ",[RestaurentsController::class,"searchForRestaurents"]);
Route::post("/saveOrders ",[NotificationsController::class,"saveOrders"]);
Route::get("/retrieveOrders ",[NotificationsController::class,"retrieveOrders"]);
Route::get("/deleteOrders ",[NotificationsController::class,"deleteOrders"]);
Route::get("/retrieveShipperNotifications ",[NotificationsController::class,"retrieveShipperNotifications"]);
Route::get("/retrieveNotifications ",[NotificationsController::class,"retrieveNotifications"]); 
Route::post("/updateNotifStatus ",[NotificationsController::class,"updateNotifStatus"]); 
Route::post("/saveShippers ",[ChefShipperController::class,"saveShippers"]);
Route::get("/retrieveShippers ",[ChefShipperController::class,"retrieveShippers"]); 
Route::get("/deleteProducts ",[ProductsController::class,"deleteProducts"]); 
Route::post("/updateRequestStatus ",[ChefShipperController::class,"updateRequestStatus"]);
Route::post("/saveProductFeedback ",[NotificationsController::class,"saveProductFeedback"]);
Route::get("/retrieveProductsFeedbacks ",[NotificationsController::class,"retrieveProductsFeedbacks"]);
Route::post("/sendProductRating ",[NotificationsController::class,"sendProductRating"]);
Route::get("/checkRating ",[NotificationsController::class,"checkRating"]);

Route::group(['middleware'=>'api'],function(){


    Route::get('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});