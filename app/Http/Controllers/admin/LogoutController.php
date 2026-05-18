<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request, LogService $logs)
    {
        $admin = Auth::guard('admin')->user();

        Auth::guard('admin')->logout();

        $logs->adminActivity('Admin logout successful.', $request, [
            'admin_id' => $admin?->id,
            'email' => $admin?->email,
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been logged out successfully.');
    }
}
