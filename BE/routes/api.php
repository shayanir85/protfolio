<?php

use App\Http\Controllers\AboutMeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ThemeSettingController;
use Illuminate\Http\Request;
use App\Http\Controllers\GithubReposController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

Route::get('/theme', [ThemeSettingController::class, 'index'])->middleware('throttle:100,5');
Route::get('/hero', [HeroSectionController::class, 'index'])->middleware('throttle:100,5');
Route::get('/about', [AboutMeController::class, 'index'])->middleware('throttle:100,5');
Route::get('/proj', [GithubReposController::class, 'index'])->middleware('throttle:100,5');
Route::get('/proj/count', [GithubReposController::class, 'count_proj'])->middleware('throttle:100,5');
Route::get('/user/socials', [SocialController::class, 'index'])->middleware('throttle:100,5');
Route::get('/user/email', [AuthController::class, 'get_email'])->middleware('throttle:100,5');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:3,1');

Route::get('/user/skills', [CategoriesController::class, 'index'])->middleware('throttle:100,5');

Route::get('/experience', [ExperienceController::class, 'index'])->middleware('throttle:100,5');
Route::get('/goals', [GoalController::class, 'index'])->middleware('throttle:100,5');