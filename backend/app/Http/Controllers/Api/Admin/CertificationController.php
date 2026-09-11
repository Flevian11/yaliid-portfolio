<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    public function index()
    {
        return response()->json(
            Certification::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->validate([
            'name' => 'required|string|max:190',
            'issuing_organization' => 'nullable|string|max:190',
            'credential_id' => 'nullable|string|max:190',
            'credential_url' => 'nullable|url|max:500',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'does_not_expire' => 'boolean',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data['display_order'] = $orderService->assignNext(new Certification());

        if ($request->hasFile('certificate_file')) {
            $data['certificate_file'] = $request->file('certificate_file')
                ->store('certificates', 'public');
        }

        $item = Certification::create($data);

        return response()->json($item->refresh(), 201);
    }

    public function show($id)
    {
        return response()->json(Certification::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Certification::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:190',
            'issuing_organization' => 'nullable|string|max:190',
            'credential_id' => 'nullable|string|max:190',
            'credential_url' => 'nullable|url|max:500',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'does_not_expire' => 'boolean',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'remove_certificate_file' => 'boolean',
        ]);

        if ($request->boolean('remove_certificate_file') && $item->certificate_file) {
            Storage::disk('public')->delete($item->certificate_file);
            $data['certificate_file'] = null;
        }

        if ($request->hasFile('certificate_file')) {
            if ($item->certificate_file) {
                Storage::disk('public')->delete($item->certificate_file);
            }

            $data['certificate_file'] = $request->file('certificate_file')
                ->store('certificates', 'public');
        }

        unset($data['remove_certificate_file']);

        $item->update($data);

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        $item = Certification::findOrFail($id);

        if ($item->certificate_file) {
            Storage::disk('public')->delete($item->certificate_file);
        }

        $item->delete();

        return response()->noContent();
    }
}
