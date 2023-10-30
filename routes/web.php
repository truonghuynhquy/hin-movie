<?php

use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TvShowController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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



Route::group(['middleware' => 'PreventBackHistory'], function () {

    Route::middleware(['PreventBackHistory', 'auth:sanctum', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Admin/Index');
        })->name('index');
        Route::resource('/movies', MovieController::class);
        Route::resource('/tv-shows', TvShowController::class);
        Route::resource('/tv-shows/{tv_show}/seasons', SeasonController::class);
        Route::resource('/tv-shows/{tv_show}/seasons/{season}/episodes', EpisodeController::class);
        Route::resource('/genres', GenreController::class);
        Route::resource('/casts', CastController::class);
        Route::resource('/tags', TagController::class);
    });

    Route::middleware(['PreventBackHistory', 'auth:sanctum', 'verified'])->get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
