<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CommentController;

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

Route::post('login',[AuthController::class, 'login']);
Route::post('register',[AuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [UserController::class, 'getAuthenticatedUser']);

    Route::prefix('users')->name('users.')->group(function () {
        // Route::post('/', [UserController::class],'store');
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::post('/', [CategoryController::class,'store']);
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });

    Route::prefix('feedbacks')->name('feedbacks.')->group(function () {
        Route::post('/', [FeedbackController::class, 'createFeedback']);
        Route::get('/', [FeedbackController::class, 'index']);
        Route::get('/{id}', [FeedbackController::class, 'show']);
        Route::put('/{id}', [FeedbackController::class, 'update']);
        Route::delete('/{id}', [FeedbackController::class, 'destroy']);
        Route::get('/{id}/comments', [CommentController::class, 'getFeedbackComments']);
    });

    Route::prefix('comments')->name('comments.')->group(function () {
        Route::post('/', [CommentController::class, 'createComment']);
        Route::get('/', [CommentController::class, 'index']);
        Route::get('/{id}', [CommentController::class, 'show']);
        Route::put('/{id}', [CommentController::class, 'update']);
        Route::delete('/{id}', [CommentController::class, 'destroy']);
    });
});

