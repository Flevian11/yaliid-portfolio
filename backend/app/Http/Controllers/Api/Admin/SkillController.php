<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return response()->json(
            Skill::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->except('display_order');
        $data['display_order'] = $orderService->assignNext(new Skill());

        return response()->json(Skill::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Skill::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Skill::findOrFail($id);
        $item->update($request->except('display_order'));

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        Skill::findOrFail($id)->delete();

        return response()->noContent();
    }
}
