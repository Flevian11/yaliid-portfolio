<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\Certification; use Illuminate\Http\Request;
class CertificationController extends Controller {
 public function index() { return response()->json(Certification::query()->latest()->paginate(50)); }
 public function store(Request $request) { return response()->json(Certification::create($request->all()),201); }
 public function show($id) { return response()->json(Certification::findOrFail($id)); }
 public function update(Request $request,$id) { $item=Certification::findOrFail($id); $item->update($request->all()); return response()->json($item->refresh()); }
 public function destroy($id) { Certification::findOrFail($id)->delete(); return response()->noContent(); }
}
