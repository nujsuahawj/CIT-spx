<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/apiregister',[App\Http\Controllers\Api\AuthApiController::class, 'apiregister']);
Route::post('/apilogin',[App\Http\Controllers\Api\AuthApiController::class, 'apilogin']);
Route::get('/apislider',[App\Http\Controllers\Api\SliderApiController::class, 'index']);
Route::get('/apiservice',[App\Http\Controllers\Api\ServiceApiController::class, 'index']);
Route::get('/apiabout', [App\Http\Controllers\Api\AboutApiController::class, 'getAbout']);
Route::get('/apiterms', [App\Http\Controllers\Api\AboutApiController::class, 'getTerms']);
Route::get('/apibranch', [App\Http\Controllers\Api\AboutApiController::class, 'getBranch']);
Route::put('/apibranchbyid/{id}', [App\Http\Controllers\Api\AboutApiController::class, 'getBranchByProid']);
Route::get('/settings/calculator_price_kgs', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getCalculatorPriceKgs']);
Route::get('/settings/calculator_price_others', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getCalculatorPriceOthers']);
Route::get('/settings/village', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getVillage']);
Route::get('/settings/{id}/village', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getVillageById']);
Route::get('/settings/district', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getDistrict']);
Route::get('/settings/{id}/district', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getDistrictById']);
Route::get('/settings/province', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getProvince']);
Route::get('/settings/{id}/province', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getProvinceById']);
Route::get('/apireceive/searchorder/{name}', [App\Http\Controllers\Api\ReceiveApiController::class, 'search']);
Route::get('/apireceive/maxIdReceive', [App\Http\Controllers\Api\ReceiveApiController::class, 'maxIdReceive']);

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::get('/apiuser', [App\Http\Controllers\Api\AuthApiController::class, 'apiuser']);
    Route::post('/user/update', [App\Http\Controllers\Api\AuthApiController::class, 'update']);
    Route::post('/apilogout/{id}', [App\Http\Controllers\Api\AuthApiController::class, 'apilogout']);
    
    //Receive
    Route::get('/apireceive/history', [App\Http\Controllers\Api\ReceiveApiController::class, 'history']);
    Route::get('/apireceive/indexorder', [App\Http\Controllers\Api\ReceiveApiController::class, 'indexbill']);
    Route::post('/apireceive/order', [App\Http\Controllers\Api\ReceiveApiController::class, 'addOrder']);
    Route::delete('/apireceives/{id}/deleteorder', [App\Http\Controllers\Api\ReceiveApiController::class, 'destroyorder']);
    Route::get('/apireceive/detail', [App\Http\Controllers\Api\DetailReceiveApiController::class,'index']);
    Route::get('/apireceive/count/{code}', [App\Http\Controllers\Api\ReceiveApiController::class, 'countIdMaterail']);
    Route::get('/apireceive/materail/{code}', [App\Http\Controllers\Api\ReceiveApiController::class, 'showmaterail']);
    Route::get('/apireceive/bill/{code}', [App\Http\Controllers\Api\ReceiveApiController::class, 'showbillreceive']);
    Route::post('/apireceive/postmaterail', [App\Http\Controllers\Api\ReceiveApiController::class, 'postMatterail']);
    Route::get('/apireceive/billall/{code}', [App\Http\Controllers\Api\ReceiveApiController::class, 'showbillallreceive']);
    Route::post('/apireceive/postreceive', [App\Http\Controllers\Api\ReceiveApiController::class, 'postReceiveTransaction']);
    
    //Callgoods
    Route::get('/callgoods', [App\Http\Controllers\Api\CallGoodsApiController::class,'index']);
    Route::post('/callgoods/store', [App\Http\Controllers\Api\CallGoodsApiController::class,'store']);
    Route::get('/callgoods/{id}/show', [App\Http\Controllers\Api\CallGoodsApiController::class,'show']);
    Route::put('/callgoods/{id}/update/', [App\Http\Controllers\Api\CallGoodsApiController::class,'update']);
    Route::delete('/callgoods/{id}/destroy/', [App\Http\Controllers\Api\CallGoodsApiController::class,'destroy']);
    
    //Settings
    Route::get('/settings/customers', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getCustomers']);
    Route::get('/settings/searchcustomers/{name}', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getSearchCustomers']);
    Route::get('/settings/roles', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getRoles']);
    Route::get('/settings/dividend', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getDividend']);
    Route::get('/settings/cod', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getCod']);
    Route::get('/settings/exchange', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getExchange']);
    Route::get('/settings/goods_type', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getGoodsType']);
    Route::get('/settings/{id}/goods_type', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getGoodsTypeById']);
    Route::get('/settings/product_type', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getProductType']);
    Route::get('/settings/{id}/product_type', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getProductTypeById']);
    Route::get('/settings/payment', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getPayment']);
    Route::get('/settings/payment_type', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getPaymentType']);
    Route::get('/settings/tax', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getTax']);
    Route::get('/settings/vihicle', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getVihicle']);
    Route::get('/settings/vihicle_type', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getVihicleType']);
    Route::get('/settings/packing', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getPacking']);
    Route::get('/settings/{id}/packing', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getPackingById']);
    Route::get('/settings/distance', [App\Http\Controllers\Api\Admin\Settings\SettingApiController::class, 'getDistance']);
    
});