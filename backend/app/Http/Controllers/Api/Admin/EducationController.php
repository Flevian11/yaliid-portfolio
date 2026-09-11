<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        return response()->json(
            Education::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->except('display_order');
        $data['display_order'] = $orderService->assignNext(new Education());

        return response()->json(Education::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Education::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Education::findOrFail($id);
        $item->update($request->except('display_order'));

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        Education::findOrFail($id)->delete();

        return response()->noContent();
    }
}
