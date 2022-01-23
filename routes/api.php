<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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
//Auth routes
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

//User routes
Route::get('/users' , [UserController::class]);
Route::post('/users' , [UserController::class]);
Route::delete('/users/{id}' , [UserController::class]);

Route::apiResource('/users', UserController::class);

//Quiz routes
Route::get('/quizzes' , [QuizController::class]);
Route::post('/quizzes', [QuizController::class,]);
Route::post('users/{user_id}/quizzes/{quiz_id}', [QuizController::class,'choose_quiz']);
Route::delete('/quizzes/{id}' , [QuizController::class]);

Route::apiResource('/quizzes', QuizController::class);


//Question routes
Route::get('/{quiz_id}/questions' , [QuestionController::class,'question_list']);
Route::post('/questions' , [QuestionController::class]);
Route::delete('/questions/{id}' , [QuestionController::class]);

Route::apiResource('/questions' , QuestionController::class);

//Choice routes
Route::get('/choices' , [ChoiceController::class,'choice_list']);
Route::post('/users/{user_id}/questions/{question_id}/choices/{choice_id}' , [ChoiceController::class,'answer_question']);
Route::delete('/choices/{id}' , [ChoiceController::class]);

Route::apiResource('/choices' , ChoiceController::class);