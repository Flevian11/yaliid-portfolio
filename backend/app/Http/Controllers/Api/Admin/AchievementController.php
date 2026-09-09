<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Achievement; use Illuminate\Http\Request;
class AchievementController extends Controller {
 public function index() { return response()->json(Achievement::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Achievement::create($request->all()),201); }
 public function show($id) { return response()->json(Achievement::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Achievement::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Achievement::findOrFail($id)->delete(); return response()->noContent(); }
}
