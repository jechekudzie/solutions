<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\OrganisationTypeController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/administration', function () {
    return view('admin.index');
});


Route::get('/administration/organisation-types', [OrganisationTypeController::class, 'index'])->name('admin.organisation-types.index');
Route::get('/administration/organisations', [OrganisationController::class, 'index'])->name('admin.organisations.index');


/*
|--------------------------------------------------------------------------
| User Management Routes
|--------------------------------------------------------------------------
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
