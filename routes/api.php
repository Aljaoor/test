<?php


use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\User_information;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::controller(\App\Http\Controllers\api\products::class)
    ->prefix('/products')
//    ->middleware(['jwt.verify'])
    ->group(function () {
        Route::post('/add', 'add');
        Route::get('/view', 'show')->middleware(['jwt.verify', 'roleChecker']);
        Route::post('/update/{id}', 'update')->middleware(['jwt.verify', 'roleChecker']);
        Route::post('/delete/{id}', 'delete')->middleware(['jwt.verify', 'roleChecker']);
        Route::post('/assign', 'assign')->middleware(['jwt.verify', 'roleChecker']);

    });

Route::post('/user/update', [User_information::class, 'update']);
Route::post('/user/changePassword', [User_information::class, 'changePassword']);
Route::get('/user/products/{id}', [User_information::class, 'products'])->middleware(['jwt.verify', 'hisProduct']);


//------------ admin manage user information -----------------

Route::post('/users/add', [AuthController::class, 'register'])->middleware(['jwt.verify', 'roleChecker']);

Route::controller(User_information::class)
    ->prefix('/users')
    ->middleware(['jwt.verify', 'roleChecker'])
    ->group(function () {
        Route::post('/update/{id}', 'edite');
        Route::get('/delete/{id}', 'delete');

    });



