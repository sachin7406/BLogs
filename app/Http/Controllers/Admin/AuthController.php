<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        // unchanged
        return view('admin.auth.login');
    }


    public function loginSubmit(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('status', 'active')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        session([
            'admin_id'   => $user->id,
            'admin_name' => $user->name,
            'admin_role' => $user->role
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('admin.login');
    }
}
