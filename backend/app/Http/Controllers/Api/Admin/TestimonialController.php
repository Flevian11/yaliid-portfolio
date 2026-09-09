<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Testimonial; use Illuminate\Http\Request;
class TestimonialController extends Controller {
 public function index() { return response()->json(Testimonial::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Testimonial::create($request->all()),201); }
 public function show($id) { return response()->json(Testimonial::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Testimonial::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Testimonial::findOrFail($id)->delete(); return response()->noContent(); }
}
