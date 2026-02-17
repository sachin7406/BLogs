<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    /* ======================
        LIST USERS (API)
    ======================= */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /* ======================
        SHOW SINGLE USER (API)
        ← this replaces edit()
    ======================= */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /* ======================
        STORE USER (API)
    ======================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                'unique:users,email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $allowedDomains = ['gmail.com', 'ddsplm.com'];
                    $emailDomain = substr(strrchr($value, "@"), 1);
                    if (!in_array(strtolower($emailDomain), $allowedDomains)) {
                        $fail('Only gmail.com or ddsplm.com email addresses are allowed.');
                    }
                },
            ],
            'password' => 'required|string|min:6',
            'role'     => 'required|string',
            'status'   => 'required|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    /* ======================
        UPDATE USER (API)
    ======================= */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $id,
            'role'   => 'required|string',
            'status' => 'required|string',
            'password' => 'nullable|min:6'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    /* ======================
        DELETE USER (API)
    ======================= */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
