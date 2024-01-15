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
    $organisation = \App\Models\Organisation::find(3);
    $organisation->organisationType->children->map(function ($item) use ($organisation) {
        $item->organisation_id = $organisation->id;
    });

    // Assuming $organisation is an instance of Organisation
    $parentOrganisation = $organisation->parentOrganisation; // This will get the parent Organisation

    dd($parentOrganisation);

    $string = "687549-ot-1";
    $parts = explode('-', $string);

// The parts will be ["687549", "ot", "1"]
// If you want to get the number after "ot-", that would be the third element in the array
    $number = isset($parts[2]) ? $parts[2] : null;

    echo $number;
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.index');
});



/*
|--------------------------------------------------------------------------
| Organisation Management Routes
|--------------------------------------------------------------------------
*/

//Display all organisation types via API
Route::get('/admin/organisation-types', [OrganisationTypeController::class, 'index'])->name('admin.organisation-types.index');
//Create new organisation types directly
Route::post('/admin/organisation-types/store', [OrganisationTypeController::class, 'store'])->name('admin.organisation-types.store');
//add organisation type of organisation type
Route::post('/admin/organisation-types/{organisationType}', [OrganisationTypeController::class, 'organisationTypeOrganisation'])->name('admin.organisation-types.organisation-type');


//Display all organisations via API
Route::get('/admin/organisations', [OrganisationController::class, 'index'])->name('admin.organisations.index');
Route::post('/admin/organisations/store', [OrganisationController::class, 'store'])->name('admin.organisations.store');
Route::patch('/admin/organisations/{organisation}/update', [OrganisationController::class, 'update'])->name('admin.organisations.update');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
