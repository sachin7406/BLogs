<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /* ======================
        LIST USERS
    ======================= */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /* ======================
        CREATE FORM
    ======================= */
    public function create()
    {
        return view('admin.users.create');
    }

    /* ======================
        STORE USER
    ======================= */
    public function store(Request $request)
    {
        try {
            // Validate input
            // Validate input, only allow gmail.com or ddsplm.com emails
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

            // Hash the password
            $validated['password'] = Hash::make($validated['password']);

            // Create the user
            $user = User::create($validated);

            // If you want to redirect after creation (to work in browser and for Ajax):
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'User created', 'user' => $user]);
            } else {
                return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
            }
        } catch (\Exception $e) {
            // Return a proper error
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Error creating user', 'error' => $e->getMessage()], 500);
            } else {
                return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
            }
        }
    }

    /* ======================
        EDIT FORM
    ======================= */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /* ======================
        UPDATE USER
    ======================= */


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $id,
            'role'   => 'required',
            'status' => 'required',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated']);
    }


    /* ======================
        DELETE USER
    ======================= */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}
