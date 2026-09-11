<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(
            Project::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->except('display_order');
        $data['display_order'] = $orderService->assignNext(new Project());

        return response()->json(Project::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Project::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Project::findOrFail($id);
        $item->update($request->except('display_order'));

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        Project::findOrFail($id)->delete();

        return response()->noContent();
    }
}
