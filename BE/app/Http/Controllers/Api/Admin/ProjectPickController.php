<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectPick;
use Illuminate\Http\Request;

class ProjectPickController extends Controller
{
    public function index()
    {
        return response()->json(
            ProjectPick::orderBy('display_order')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'repo_name' => 'required|string',
            'display_order' => 'integer|nullable',
            'is_active' => 'boolean|nullable',
        ]);

        $pick = ProjectPick::create($validated);

        return response()->json($pick, 201);
    }

    public function update(Request $request, ProjectPick $projectPick)
    {
        $validated = $request->validate([
            'repo_name' => 'sometimes|string',
            'display_order' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $projectPick->update($validated);

        return response()->json($projectPick);
    }

    public function destroy(ProjectPick $projectPick)
    {
        $projectPick->delete();

        return response()->json(null, 204);
    }
}
