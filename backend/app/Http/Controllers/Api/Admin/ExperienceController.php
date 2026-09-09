<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Experience; use Illuminate\Http\Request;
class ExperienceController extends Controller {
 public function index() { return response()->json(Experience::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Experience::create($request->all()),201); }
 public function show($id) { return response()->json(Experience::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Experience::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Experience::findOrFail($id)->delete(); return response()->noContent(); }
}
