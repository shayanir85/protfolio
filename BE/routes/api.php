<?php

use Illuminate\Http\Request;
use App\Http\Controllers\GithubReposController;
use Illuminate\Support\Facades\Route;

Route::get('/proj', [GithubReposController::class, 'index'])->middleware('throttle:10,2');
