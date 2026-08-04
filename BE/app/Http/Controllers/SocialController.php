<?php

namespace App\Http\Controllers;

use App\Models\SocialLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SocialController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $cacheKey = "social_links_{$locale}";

        $links = Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return SocialLinks::all();
        });

        if ($links->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($links);
    }

}
