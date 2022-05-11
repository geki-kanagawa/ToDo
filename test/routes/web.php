<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

Route::get('/', function () {
    return 'Hello World';
});
Route::get('/task', [TaskController::class, 'index']);
Route::post('/gettask', [TaskController::class, 'getTask']);
Route::post('/instask', [TaskController::class, 'insTask']);
Route::post('/edittask', [TaskController::class, 'editTask']);
Route::post('/deletetask', [TaskController::class, 'deleteTask']);