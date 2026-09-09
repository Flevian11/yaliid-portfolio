<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Advertisement; use Illuminate\Http\Request;
class AdvertisementController extends Controller {
 public function index() { return response()->json(Advertisement::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Advertisement::create($request->all()),201); }
 public function show($id) { return response()->json(Advertisement::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Advertisement::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Advertisement::findOrFail($id)->delete(); return response()->noContent(); }
}
