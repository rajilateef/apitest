<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

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

Route::group(['prefix' => 'articles'],function () {
    Route::get('/', [ArticleController::class, 'getArticles']);
    Route::get('/{id}', [ArticleController::class, 'getArticle']);
    Route::post('/{id}/like', [ArticleController::class, 'likeArticle']);
    Route::post('/{id}/comment', [CommentController::class, 'createComment']);
    Route::delete('/{article}', [ArticleController::class, 'getArticles']);
    Route::get('/{id}/view', [ArticleController::class, 'showCount']);
    Route::post('/create', [ArticleController::class, 'createArticle']);
});
