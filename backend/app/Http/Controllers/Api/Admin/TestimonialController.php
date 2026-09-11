<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return response()->json(
            Testimonial::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->validate([
            'name' => 'required|string|max:190',
            'organization' => 'nullable|string|max:190',
            'position' => 'nullable|string|max:190',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'rating' => 'nullable|integer|min:0|max:5',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        $data['display_order'] = $orderService->assignNext(new Testimonial());

        return response()->json(Testimonial::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Testimonial::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Testimonial::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:190',
            'organization' => 'nullable|string|max:190',
            'position' => 'nullable|string|max:190',
            'content' => 'sometimes|required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'rating' => 'nullable|integer|min:0|max:5',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'remove_file' => 'boolean',
        ]);

        if ($request->boolean('remove_file') && $item->photo) {
            Storage::disk('public')->delete($item->photo);
            $data['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $data['photo'] = $request->file('photo')->store('testimonials', 'public');
        }

        unset($data['remove_file']);
        $item->update($data);

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        $item = Testimonial::findOrFail($id);

        if ($item->photo) {
            Storage::disk('public')->delete($item->photo);
        }

        $item->delete();

        return response()->noContent();
    }
}
