<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences = Experience::orderBy('start_date', 'desc')->get();

        $data = $experiences->map(function ($exp) {
            $startDate = $exp->start_date ? $exp->start_date->format('Y-m-d') : '';
            $endDate = $exp->end_date ? $exp->end_date->format('Y-m-d') : null;

            if ($endDate) {
                $period = "{$startDate} -> {$endDate}";
            } else {
                $period = "{$startDate} -> current job";
            }

            return [
                'id' => $exp->id,
                'title' => $exp->title,
                'position' => $exp->position,
                'explanation' => $exp->explanation,
                'company' => $exp->title,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'period' => $period,
            ];
        });

        return response()->json($data);
    }
}
