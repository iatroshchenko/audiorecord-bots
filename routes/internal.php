<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Internal\TagController;

Route::get('tags', [
    TagController::class, 'all'
])->middleware('auth');
Route::post('tags', [
    TagController::class, 'addTagFromInput'
]);

//Route::post('records', [
//
//]);
