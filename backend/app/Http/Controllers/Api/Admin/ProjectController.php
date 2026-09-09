<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Project; use Illuminate\Http\Request;
class ProjectController extends Controller {
 public function index() { return response()->json(Project::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Project::create($request->all()),201); }
 public function show($id) { return response()->json(Project::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Project::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Project::findOrFail($id)->delete(); return response()->noContent(); }
}
