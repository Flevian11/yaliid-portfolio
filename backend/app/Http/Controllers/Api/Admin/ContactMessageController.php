<?php
namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller; use App\Models\ContactMessage; use Illuminate\Http\Request;
class ContactMessageController extends Controller {
 public function index(){return response()->json(ContactMessage::latest()->paginate(50));}
 public function show($id){return response()->json(ContactMessage::findOrFail($id));}
 public function update(Request $request,$id){$item=ContactMessage::findOrFail($id);$item->update($request->validate(['status'=>'sometimes|in:unread,read,archived']));if($item->status==='read'&&!$item->read_at)$item->update(['read_at'=>now()]);return response()->json($item->refresh());}
 public function destroy($id){ContactMessage::findOrFail($id)->delete();return response()->noContent();}
}
