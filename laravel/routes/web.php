<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Models\Person;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/people', [PersonController::class, 'index'])->name('people.index');
    Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
    Route::post('/people', [PersonController::class, 'store'])->name('people.store');
    Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');
});

Route::get('/dashboard', [PersonController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-degree', function () {
    // DB::enableQueryLog();
    // $timestart = microtime(true);

    // $person = Person::findOrFail(84);
    // $degree = $person->getDegreeWith(1265);

    // $time = microtime(true) - $timestart;
    // $queries = count(DB::getQueryLog());

    // return response()->json([
    //     "degree" => $degree,
    //     "time" => $time,
    //     "nb_queries" => $queries,
    // ]);
    
    DB::enableQueryLog();
    $timestart = microtime(true);

    $person = Person::findOrFail(84);
    $result = $person->getDegreeWith(1265);

    $time = microtime(true) - $timestart;
    $queries = count(DB::getQueryLog());

    return response()->json([
        "degree" => $result['degree'],
        "path" => implode(' -> ', $result['path']),
        "time" => $time,
        "nb_queries" => $queries,
    ]);
});
require __DIR__.'/auth.php';

