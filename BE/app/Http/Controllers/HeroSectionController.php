<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    /**
     * Display the active Hero Section configuration.
     */
    public function index(): JsonResponse
    {
        $hero = HeroSection::where('is_active', true)
            ->latest('updated_at')
            ->first();

        if (!$hero) {
            return response()->json(null);
        }

        return response()->json([
            'id' => $hero->id,
            'badge_text' => $hero->badge_text,
            'greeting' => $hero->greeting,
            'name' => $hero->name,
            'title' => $hero->title,
            'description' => $hero->description,
            'show_availability' => (bool) $hero->show_availability,
            'availability_status' => $hero->availability_status ?? 'available',
            'availability_pulse' => (bool) $hero->availability_pulse,
            'enable_typewriter' => (bool) $hero->enable_typewriter,
            'typewriter_prefix' => $hero->typewriter_prefix,
            'typewriter_strings' => $hero->typewriter_strings ?? [],
            'typewriter_speed' => $hero->typewriter_speed ?? 80,
            'typewriter_delete_speed' => $hero->typewriter_delete_speed ?? 40,
            'typewriter_delay' => $hero->typewriter_delay ?? 2000,
            'buttons' => $hero->buttons ?? [],
            'stats' => $hero->stats ?? [],
            'scroll_indicator_text' => $hero->scroll_indicator_text,
            'show_scroll_indicator' => (bool) $hero->show_scroll_indicator,
            'is_active' => (bool) $hero->is_active,
            'updated_at' => $hero->updated_at?->toISOString(),
        ]);
    }
}
