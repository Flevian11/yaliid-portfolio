<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\SiteSetting; use Illuminate\Http\Request;
class SiteSettingController extends Controller {
 public function index() { return response()->json(SiteSetting::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(SiteSetting::create($request->all()),201); }
 public function show($id) { return response()->json(SiteSetting::findOrFail($id)); }
 public function update(Request $request,$id) { $item=SiteSetting::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { SiteSetting::findOrFail($id)->delete(); return response()->noContent(); }
}
