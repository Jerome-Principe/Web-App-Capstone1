<?php

// CSRF token refresh route to prevent 419 errors
Route::get('/csrf-refresh', function () {
    return response()->json(['csrf_token' => csrf_token()])
        ->header('X-CSRF-TOKEN', csrf_token());
})->middleware('web');
