<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Display a listing of active goals.
     */
    public function index(): JsonResponse
    {
        $goals = Goal::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = $goals->map(function ($goal) {
            return [
                'id' => $goal->id,
                'text' => $goal->text,
                'icon' => $goal->icon ?: 'emoji_events',
                'sort_order' => $goal->sort_order,
                'is_active' => (bool) $goal->is_active,
            ];
        });

        return response()->json($data);
    }
}
