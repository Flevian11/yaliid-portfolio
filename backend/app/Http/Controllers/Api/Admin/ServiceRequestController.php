<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\ServiceRequest; use Illuminate\Http\Request;
class ServiceRequestController extends Controller {
 public function index(){return response()->json(ServiceRequest::with('service')->latest()->paginate(50));}
 public function show($id){return response()->json(ServiceRequest::with(['service','attachments'])->findOrFail($id));}
 public function update(Request $request,$id){$item=ServiceRequest::findOrFail($id);$item->update($request->validate(['status'=>'sometimes|in:new,reviewing,quoted,approved,in_progress,completed,cancelled','priority'=>'sometimes|in:low,normal,high','admin_notes'=>'nullable|string|max:10000']));return response()->json($item->refresh());}
 public function destroy($id){ServiceRequest::findOrFail($id)->delete();return response()->noContent();}
}
