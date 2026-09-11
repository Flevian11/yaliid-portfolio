<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|min:4|max:128',
        ]);

        $admin = User::query()
            ->whereIn('role', ['admin', 'super_admin'])
            ->orderBy('id')
            ->first();

        if (!$admin) {
            return response()->json(['message' => 'No admin account is configured.'], 503);
        }

        $setting = SiteSetting::query()
            ->where('key', 'admin_access_key_hash')
            ->first();

        if ($setting) {
            $valid = Hash::check($data['key'], (string) $setting->value);
        } else {
            // Initial bootstrap key. It is immediately converted to a hash after a successful login.
            $valid = hash_equals('24HF', $data['key']);
        }

        if (!$valid) {
            return response()->json(['message' => 'Invalid admin key.'], 422);
        }

        if (!$setting) {
            SiteSetting::updateOrCreate(
                ['key' => 'admin_access_key_hash'],
                [
                    'value' => Hash::make($data['key']),
                    'type' => 'secret',
                    'group' => 'security',
                ]
            );
        }

        Auth::login($admin);
        $request->session()->regenerate();

        return response()->json(['user' => $request->user()]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out.']);
    }

    public function changeKey(Request $request)
    {
        abort_unless(
            $request->user() && in_array($request->user()->role, ['admin', 'super_admin'], true),
            403
        );

        $data = $request->validate([
            'current_key' => 'required|string|min:4|max:128',
            'new_key' => 'required|string|min:4|max:128|different:current_key',
            'new_key_confirmation' => 'required|string|same:new_key',
        ]);

        $setting = SiteSetting::query()
            ->where('key', 'admin_access_key_hash')
            ->first();

        $currentValid = $setting
            ? Hash::check($data['current_key'], (string) $setting->value)
            : hash_equals('24HF', $data['current_key']);

        if (!$currentValid) {
            return response()->json(['message' => 'Current admin key is incorrect.'], 422);
        }

        SiteSetting::updateOrCreate(
            ['key' => 'admin_access_key_hash'],
            [
                'value' => Hash::make($data['new_key']),
                'type' => 'secret',
                'group' => 'security',
            ]
        );

        return response()->json(['message' => 'Admin key changed successfully.']);
    }
}
