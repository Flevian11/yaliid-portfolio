<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json(Profile::query()->latest()->paginate(50));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:190',
            'professional_title' => 'required|string|max:190',
            'tagline' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'professional_summary' => 'nullable|string',
            'profile_photo' => 'nullable|string|max:500',
            'hero_image' => 'nullable|string|max:500',
            'email' => 'required|email|max:190',
            'phone' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:190',
            'availability_status' => 'nullable|string|max:190',
            'availability_text' => 'nullable|string',
            'is_active' => 'boolean',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('cvs', 'public');
            $data['cv_updated_at'] = now();
        }

        $item = Profile::create($data);

        return response()->json($item->refresh(), 201);
    }

    public function show($id)
    {
        return response()->json(Profile::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Profile::findOrFail($id);

        $data = $request->validate([
            'full_name' => 'sometimes|required|string|max:190',
            'professional_title' => 'sometimes|required|string|max:190',
            'tagline' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'professional_summary' => 'nullable|string',
            'profile_photo' => 'nullable|string|max:500',
            'hero_image' => 'nullable|string|max:500',
            'email' => 'sometimes|required|email|max:190',
            'phone' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:190',
            'availability_status' => 'nullable|string|max:190',
            'availability_text' => 'nullable|string',
            'is_active' => 'boolean',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'remove_file' => 'boolean',
        ]);

        if ($request->boolean('remove_file') && $item->cv_file) {
            Storage::disk('public')->delete($item->cv_file);
            $data['cv_file'] = null;
            $data['cv_updated_at'] = null;
        }

        if ($request->hasFile('cv_file')) {
            if ($item->cv_file) {
                Storage::disk('public')->delete($item->cv_file);
            }

            $data['cv_file'] = $request->file('cv_file')->store('cvs', 'public');
            $data['cv_updated_at'] = now();
        }

        unset($data['remove_file']);

        $item->update($data);

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        $item = Profile::findOrFail($id);

        if ($item->cv_file) {
            Storage::disk('public')->delete($item->cv_file);
        }

        $item->delete();

        return response()->noContent();
    }
}
