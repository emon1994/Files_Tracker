<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CountryController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/client', [ClientController::class, 'index'])->name('client');
Route::post('/client-information', [ClientController::class, 'store'])->name('client-information');
Route::get('/client-list', [ClientController::class, 'showClientList'])->name('client-list');
Route::get('/delete-client/{id}', [ClientController::class, 'deleteClient'])->name('delete-client');
Route::get('/edit-client/{id}', [ClientController::class, 'editClient'])->name('edit-client');
Route::post('/update-client/{id}', [ClientController::class, 'updateClient'])->name('update-client');
Route::get('/view-client-files/{id}', [ClientController::class, 'ViewClientFile'])->name('view-client-files');

Route::get('/submit-file', [FileController::class, 'submitFile'])->name('submit-file');

Route::post('/file-information', [FileController::class, 'store'])->name('file-information');

Route::get('/file-list', [FileController::class, 'showFiles'])->name('file-list');

Route::get('/delete-file/{id}', [FileController::class, 'deleteFile'])->name('delete-file');


Route::get('/edit-file/{id}', [FileController::class, 'edit'])->name('edit-file');

Route::put('/files/{id}', [FileController::class, 'update'])->name('update-file');

Route::get('delete-filedetail/{id}', [FileController::class, 'deleteFileDetail'])->name('delete-filedetail');

Route::get('/transfer-file/{id}', [FileController::class, 'showTransferForm'])->name('transfer-file');

Route::post('/save-transfer/{id}', [FileController::class, 'transferFile'])->name('save-transfer');

Route::get('/add-country', [CountryController::class, 'Index'])->name('add-country');

Route::post('/save-country', [CountryController::class, 'Store'])->name('save-country');

Route::get('/country-list', [CountryController::class, 'Show'])->name('country-list');

Route::get('/edit-country/{id}', [CountryController::class, 'EditCountry'])->name('edit-country');

Route::post('/update-country/{id}', [CountryController::class, 'UpdateCountry'])->name('update-country');

Route::get('/delete-country/{id}', [CountryController::class, 'deleteCountry'])->name('delete-country');

// routes/web.php
// Route::get('/fetch-data', [CountryController::class, 'fetchDataByCountry'])->name('fetch.data');
Route::get('/files/filter', [CountryController::class, 'filterFilesByCountry'])->name('filter.files.by.country');

Route::get('/export-file', [CountryController::class, 'exportFileByCountry'])->name('export-file');

Route::get('/export-client-file', [ClientController::class, 'exportClientFiles'])->name('export-client-file');




// Route for handling the update request






























Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
