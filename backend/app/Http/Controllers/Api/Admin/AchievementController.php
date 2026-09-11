<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        return response()->json(
            Achievement::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->except('display_order');
        $data['display_order'] = $orderService->assignNext(new Achievement());

        return response()->json(Achievement::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Achievement::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Achievement::findOrFail($id);
        $item->update($request->except('display_order'));

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        Achievement::findOrFail($id)->delete();

        return response()->noContent();
    }
}
