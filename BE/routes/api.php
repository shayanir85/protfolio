<?php

use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\Admin\EavEntityController;
use App\Http\Controllers\Api\Admin\ProjectPickController;
use Illuminate\Support\Facades\Route;

// Public API
Route::get('/page', [PageController::class, 'show']);
Route::get('/projects', [ProjectController::class, 'index']);

// Admin API (protected)
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/admin/page', function (\Illuminate\Http\Request $request) {
        $page = \App\Models\Page::where('slug', 'home')->firstOrFail();
        $validated = $request->validate(['layout' => 'required|array']);
        $page->update(['layout' => $validated['layout']]);
        return response()->json($page);
    });

    Route::post('/admin/eav-entities', [EavEntityController::class, 'store']);
    Route::put('/admin/eav-entities/{eav_entity}', [EavEntityController::class, 'update']);
    Route::delete('/admin/eav-entities/{eav_entity}', [EavEntityController::class, 'destroy']);

    Route::get('/admin/project-picks', [ProjectPickController::class, 'index']);
    Route::post('/admin/project-picks', [ProjectPickController::class, 'store']);
    Route::put('/admin/project-picks/{project_pick}', [ProjectPickController::class, 'update']);
    Route::delete('/admin/project-picks/{project_pick}', [ProjectPickController::class, 'destroy']);
});
