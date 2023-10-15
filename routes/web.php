<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Author\AuthorController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Book\BookController ;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix("dashboard")->middleware(['auth'])->group(function() {
    Route::get("/", [AdminController::class, 'dashboard']);

    Route::get("book/ajax", [BookController::class, "listBooks"]);
    Route::resource("book", BookController::class);

    Route::get("author/ajax", [AuthorController::class, "listAuthors"]);
    Route::resource("author", AuthorController::class);
    Route::post("/logout", [AuthController::class, 'logout']);
});
