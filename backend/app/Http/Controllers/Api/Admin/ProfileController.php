<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Profile; use Illuminate\Http\Request;
class ProfileController extends Controller {
 public function index() { return response()->json(Profile::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Profile::create($request->all()),201); }
 public function show($id) { return response()->json(Profile::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Profile::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Profile::findOrFail($id)->delete(); return response()->noContent(); }
}
