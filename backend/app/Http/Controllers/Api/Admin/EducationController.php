<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Education; use Illuminate\Http\Request;
class EducationController extends Controller {
 public function index() { return response()->json(Education::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Education::create($request->all()),201); }
 public function show($id) { return response()->json(Education::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Education::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Education::findOrFail($id)->delete(); return response()->noContent(); }
}
