<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\EavEntity;
use Illuminate\Http\Request;

class EavEntityController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'data' => 'required|array',
        ]);

        $entity = EavEntity::create($validated);

        return response()->json($entity, 201);
    }

    public function update(Request $request, EavEntity $eavEntity)
    {
        $validated = $request->validate([
            'type' => 'sometimes|string',
            'data' => 'sometimes|array',
        ]);

        $eavEntity->update($validated);

        return response()->json($eavEntity);
    }

    public function destroy(EavEntity $eavEntity)
    {
        $eavEntity->delete();

        return response()->json(null, 204);
    }
}
