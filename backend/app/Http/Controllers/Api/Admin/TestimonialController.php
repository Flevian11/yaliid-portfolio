<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\AdminDisplayOrderService;
use Illuminate\Http\Request;

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
        $data = $request->except('display_order');
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
        $item->update($request->except('display_order'));

        return response()->json($item->refresh());
    }

    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();

        return response()->noContent();
    }
}
