<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        return response()->json(
            Advertisement::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->except('display_order');
        $data['display_order'] = $orderService->assignNext(new Advertisement());

        return response()->json(Advertisement::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Advertisement::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Advertisement::findOrFail($id);
        $item->update($request->except('display_order'));

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        Advertisement::findOrFail($id)->delete();

        return response()->noContent();
    }
}
