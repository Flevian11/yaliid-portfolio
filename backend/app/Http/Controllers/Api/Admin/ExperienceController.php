<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return response()->json(
            Experience::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->except('display_order');
        $data['display_order'] = $orderService->assignNext(new Experience());

        return response()->json(Experience::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Experience::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Experience::findOrFail($id);
        $item->update($request->except('display_order'));

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        Experience::findOrFail($id)->delete();

        return response()->noContent();
    }
}
