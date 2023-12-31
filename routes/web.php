<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PestTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PestImageController;
use App\Http\Controllers\PesticideController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', function () {
        return redirect(route('dashboard.index'));
    });

    Route::resources([
        'pest-types' => PestTypeController::class,
        'pest-images' => PestImageController::class,
        'pests' => PestController::class,
        'dashboard' => DashboardController::class,
        'pesticides' => PesticideController::class,
    ]);

    // Export
    Route::get('export-pest-types/', [PestTypeController::class, 'export']);

});

require __DIR__.'/auth.php';
