<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Internal\{TagController, RecordController};
use App\Http\Controllers\Internal\UploadController;

/* Tags */
Route::get('tags', [ TagController::class, 'all' ])->middleware('auth');
Route::post('tags', [ TagController::class, 'addTagFromInput' ])->middleware('auth');
/* Tags */

/* Records */
Route::post('records/upload', [ UploadController::class, 'uploadRecord' ])
    ->name('internal.records.upload')
    ->middleware('auth');

Route::post('records', [ RecordController::class, 'create' ])
    ->name('internal.records.store')
    ->middleware('auth');
/* Records */

