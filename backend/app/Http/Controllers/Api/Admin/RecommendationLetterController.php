<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecommendationLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecommendationLetterController extends Controller
{
    public function index()
    {
        return response()->json(
            RecommendationLetter::with('experience')
                ->latest()
                ->paginate(50)
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'experience_id' => 'required|exists:experiences,id',
            'title' => 'required|string|max:190',
            'issuer_name' => 'nullable|string|max:150',
            'issuer_position' => 'nullable|string|max:150',
            'issuer_organization' => 'nullable|string|max:190',
            'issue_date' => 'nullable|date',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $file = $request->file('file');

        $data['file_path'] = $file->store(
            'recommendation-letters',
            'public'
        );

        $data['file_name'] = $file->getClientOriginalName();
        $data['mime_type'] = $file->getMimeType();
        $data['file_size'] = $file->getSize();

        unset($data['file']);

        $item = RecommendationLetter::create($data);

        return response()->json(
            $item->load('experience'),
            201
        );
    }

    public function show($id)
    {
        return response()->json(
            RecommendationLetter::with('experience')->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $item = RecommendationLetter::findOrFail($id);

        $data = $request->validate([
            'experience_id' => 'nullable|exists:experiences,id',
            'title' => 'sometimes|required|string|max:190',
            'issuer_name' => 'nullable|string|max:150',
            'issuer_position' => 'nullable|string|max:150',
            'issuer_organization' => 'nullable|string|max:190',
            'issue_date' => 'nullable|date',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'remove_file' => 'boolean',
        ]);

        if ($request->boolean('remove_file') && $item->file_path) {
            Storage::disk('public')->delete($item->file_path);

            $data['file_path'] = null;
            $data['file_name'] = null;
            $data['mime_type'] = null;
            $data['file_size'] = null;
        }

        if ($request->hasFile('file')) {
            if ($item->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }

            $file = $request->file('file');

            $data['file_path'] = $file->store(
                'recommendation-letters',
                'public'
            );

            $data['file_name'] = $file->getClientOriginalName();
            $data['mime_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        unset($data['file'], $data['remove_file']);

        $item->update($data);

        return response()->json(
            $item->refresh()->load('experience')
        );
    }

    public function destroy($id)
    {
        $item = RecommendationLetter::findOrFail($id);

        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return response()->noContent();
    }
}
