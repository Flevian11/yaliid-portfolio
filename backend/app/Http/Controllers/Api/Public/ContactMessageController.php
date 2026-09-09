<?php
namespace App\Http\Controllers\Api\Public;
use App\Http\Controllers\Controller; use App\Models\ContactMessage; use Illuminate\Http\Request; use Illuminate\Http\JsonResponse;
class ContactMessageController extends Controller { public function store(Request $request): JsonResponse { $data=$request->validate(['name'=>'required|string|max:150','email'=>'required|email|max:190','phone'=>'nullable|string|max:50','subject'=>'required|string|max:200','message'=>'required|string|max:10000']); $data['status']='unread'; ContactMessage::create($data); return response()->json(['message'=>'Message received.'],201); } }
