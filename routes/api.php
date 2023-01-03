<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\MasterQuizController;
use App\Http\Controllers\MasterQuizQuestionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoContentController;
use App\Models\Exam;
use App\Models\Laboratorium;
use App\Models\MasterQuiz;
use App\Models\VideoContent;
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

Route::get('test', function () {
    return 'testing';
});

Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {


    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('attachment', AttachmentController::class);
    Route::post('uploadCkEditor', [AttachmentController::class, 'uploadCkEditor']);
    Route::resource('comment', CommentController::class);
    Route::resource('rating', RatingController::class);
    Route::put('RatingVideoContent/{id}', [VideoContentController::class, 'RatingVideoContent']);

    Route::resource('videoContent', VideoContentController::class);
    Route::resource('laboratorium', LaboratoriumController::class);
    Route::resource('exam', ExamController::class);
    Route::put('saveQuiz/{id}', [ExamController::class, 'saveQuiz']);
    Route::get('updateTime/{id}', [ExamController::class, 'updateTime']);

    Route::resource('masterQuiz', MasterQuizController::class);

    Route::resource('masterQuizQuestion', MasterQuizQuestionController::class);

    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
