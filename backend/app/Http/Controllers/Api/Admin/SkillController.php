<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Skill; use Illuminate\Http\Request;
class SkillController extends Controller {
 public function index() { return response()->json(Skill::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Skill::create($request->all()),201); }
 public function show($id) { return response()->json(Skill::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Skill::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Skill::findOrFail($id)->delete(); return response()->noContent(); }
}
