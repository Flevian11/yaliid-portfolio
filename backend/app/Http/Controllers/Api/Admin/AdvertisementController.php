<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->validate([
            'title' => 'required|string|max:190',
            'description' => 'nullable|string',
            'image_path' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'destination_url' => 'nullable|url|max:500',
            'position' => 'nullable|string|max:100',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'boolean',
        ]);

        $file = $request->file('image_path');
        $data['image_path'] = $file->store('advertisements', 'public');
        $data['position'] = $data['position'] ?? 'home';
        $data['is_active'] = $data['is_active'] ?? true;
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

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:190',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'destination_url' => 'nullable|url|max:500',
            'position' => 'nullable|string|max:100',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image_path')) {
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('advertisements', 'public');
        }

        $item->update($data);

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        $item = Advertisement::findOrFail($id);

        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return response()->noContent();
    }
}
