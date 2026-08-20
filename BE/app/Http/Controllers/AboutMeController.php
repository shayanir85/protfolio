<?php

namespace App\Http\Controllers;

use App\Models\AboutMe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    /**
     * Display the dynamic About Me data.
     */
    public function index(): JsonResponse
    {
        $aboutMe = AboutMe::where('is_active', true)
            ->latest('updated_at')
            ->first();

        if (!$aboutMe) {
            return response()->json(null);
        }

        $content = $aboutMe->content;

        // If both content and title are empty, treat as no data
        if (empty($content) && empty($aboutMe->title)) {
            return response()->json(null);
        }

        return response()->json([
            'id' => $aboutMe->id,
            'title' => $aboutMe->title,
            'subtitle' => $aboutMe->subtitle,
            'avatar_url' => $aboutMe->avatar_url,
            'content' => $content,
            'is_active' => (bool) $aboutMe->is_active,
            'updated_at' => $aboutMe->updated_at?->toISOString(),
        ]);
    }
}
