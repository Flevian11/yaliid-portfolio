<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Service; use Illuminate\Http\Request;
class ServiceController extends Controller {
 public function index() { return response()->json(Service::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Service::create($request->all()),201); }
 public function show($id) { return response()->json(Service::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Service::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Service::findOrFail($id)->delete(); return response()->noContent(); }
}
