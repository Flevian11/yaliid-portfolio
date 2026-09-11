<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(
            Service::query()->orderBy('display_order')->orderByDesc('id')->paginate(50)
        );
    }

    public function store(Request $request, AdminDisplayOrderService $orderService)
    {
        $data = $request->except(['display_order', 'slug']);
        $data['slug'] = $this->uniqueSlug((string) $data['name']);
        $data['display_order'] = $orderService->assignNext(new Service());

        return response()->json(Service::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Service::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $item = Service::findOrFail($id);
        $data = $request->except(['display_order', 'slug']);

        if (array_key_exists('name', $data)) {
            $data['slug'] = $this->uniqueSlug((string) $data['name'], $item->id);
        }

        $item->update($data);

        return response()->json($item->refresh());
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'service';
        $slug = $base;
        $suffix = 2;

        while (
            Service::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $suffix++;
        }

        return $slug;
    }

    public function destroy($id)
    {
        Service::findOrFail($id)->delete();

        return response()->noContent();
    }
}
