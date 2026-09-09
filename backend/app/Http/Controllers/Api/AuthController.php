<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {
 public function login(Request $request){$data=$request->validate(['email'=>'required|email','password'=>'required|string']); if(!Auth::attempt($data)){return response()->json(['message'=>'Invalid credentials.'],422);} $request->session()->regenerate(); return response()->json(['user'=>$request->user()]);}
 public function me(Request $request){return response()->json($request->user());}
 public function logout(Request $request){Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return response()->json(['message'=>'Logged out.']);}
}
