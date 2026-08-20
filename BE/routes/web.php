<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect('/admin');
});

// Fallback route to serve uploaded public storage files directly
Route::get('/storage/{path}', function ($path) {
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $file = Storage::disk('public')->get($path);
    $type = Storage::disk('public')->mimeType($path);

    return Response::make($file, 200, [
        'Content-Type' => $type,
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*');

