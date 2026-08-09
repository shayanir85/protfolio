<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\GithubReposController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

Route::get('/proj', [GithubReposController::class, 'index'])->middleware('throttle:100,5');
Route::get('/proj/count', [GithubReposController::class, 'count_proj'])->middleware('throttle:100,5');
Route::get('/user/socials', [SocialController::class, 'index'])->middleware('throttle:100,5');
Route::get('/user/email', [AuthController::class, 'get_email'])->middleware('throttle:100,5');
Route::post('/contact', [ContactController::class, 'store']);