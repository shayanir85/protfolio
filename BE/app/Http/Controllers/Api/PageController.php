<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EavEntity;
use App\Models\Page;

class PageController extends Controller
{
    public function show()
    {
        $page = Page::where('slug', 'home')->firstOrFail();

        $entityIds = collect();
        if ($page->layout && isset($page->layout['rows'])) {
            foreach ($page->layout['rows'] as $row) {
                foreach ($row['columns'] ?? [] as $col) {
                    foreach ($col['blocks'] ?? [] as $block) {
                        if (isset($block['entity_id']) && $block['entity_id']) {
                            $entityIds->push($block['entity_id']);
                        }
                    }
                }
            }
        }

        $entities = EavEntity::whereIn('id', $entityIds->unique())->get()->keyBy('id');

        return response()->json([
            'layout' => $page->layout,
            'entities' => $entities,
        ]);
    }
}
