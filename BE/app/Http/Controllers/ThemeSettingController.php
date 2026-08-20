<?php

namespace App\Http\Controllers;

use App\Models\ThemeSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThemeSettingController extends Controller
{
    /**
     * Display the active theme colors.
     */
    public function index(): JsonResponse
    {
        $theme = ThemeSetting::where('is_active', true)
            ->latest('updated_at')
            ->first();

        if (!$theme) {
            return response()->json([
                'primary_color' => '#667eea',
                'secondary_color' => '#764ba2',
                'accent_color' => '#06b6d4',
                'gradient_start' => '#667eea',
                'gradient_end' => '#764ba2',
                'gradient_angle' => '135deg',
                'dark_primary_color' => '#818cf8',
                'dark_secondary_color' => '#a78bfa',
                'is_active' => true,
            ]);
        }

        return response()->json([
            'id' => $theme->id,
            'primary_color' => $theme->primary_color ?: '#667eea',
            'secondary_color' => $theme->secondary_color ?: '#764ba2',
            'accent_color' => $theme->accent_color ?: '#06b6d4',
            'gradient_start' => $theme->gradient_start ?: '#667eea',
            'gradient_end' => $theme->gradient_end ?: '#764ba2',
            'gradient_angle' => $theme->gradient_angle ?: '135deg',
            'dark_primary_color' => $theme->dark_primary_color ?: '#818cf8',
            'dark_secondary_color' => $theme->dark_secondary_color ?: '#a78bfa',
            'is_active' => (bool) $theme->is_active,
            'updated_at' => $theme->updated_at?->toISOString(),
        ]);
    }
}
