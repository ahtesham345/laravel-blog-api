<?php


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/loginuser', [AuthController::class, 'login']);
Route::post('/signupuser',[AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/profile',function (Request $request) {
        $users = User::all();
        return response()->json([

            'authentic_user' => auth()->user()
        ], Response::HTTP_OK);
    });

    Route::post('/logout', [AuthController::class, 'logout']);


    Route::post('/post', [PostController::class, 'store']);
    Route::get('/userposts', [PostController::class, 'index']);
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::delete('/delete/{id}', [PostController::class, 'destroy']);
});
