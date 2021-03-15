<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Internal\{TagController, RecordController};
use App\Http\Controllers\Internal\UploadController;

Route::get('tags', [ TagController::class, 'all' ])->middleware('auth');
Route::post('tags', [ TagController::class, 'addTagFromInput' ])->middleware('auth');

Route::post('records/upload', [ UploadController::class, 'uploadRecord' ])
    ->name('internal.record.upload')
    ->middleware('auth');

Route::post('records', [ RecordController::class, 'create' ])
    ->middleware('auth');

