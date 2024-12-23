<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('cari');
        $role = $request->get('role');
        $users = User::where(function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%")
                              ->orWhere('email', 'LIKE', "%$search%");
                    })
                    ->when($role, function ($query, $role) {
                        return $query->where('role', $role);
                    })
                     ->paginate(10);
        return view('pengguna.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'pelanggan') {
            return redirect()->route('pelanggan.edit', $user->id);
        }

        return view('pengguna.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
    
}
