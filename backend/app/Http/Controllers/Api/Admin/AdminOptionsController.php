<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\SkillCategory;

class AdminOptionsController extends Controller
{
    public function experiences()
    {
        return response()->json(
            Experience::query()
                ->select(['id', 'organization', 'position', 'start_date', 'end_date', 'is_current'])
                ->orderBy('display_order')
                ->orderByDesc('id')
                ->get()
                ->map(fn (Experience $experience) => [
                    'value' => $experience->id,
                    'label' => trim($experience->organization . ' — ' . $experience->position),
                ])
        );
    }

    public function skillCategories()
    {
        return response()->json(
            SkillCategory::query()
                ->select(['id', 'name'])
                ->orderBy('display_order')
                ->orderByDesc('id')
                ->get()
                ->map(fn (SkillCategory $category) => [
                    'value' => $category->id,
                    'label' => $category->name,
                ])
        );
    }
}
