<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Validasi Ekstra
        if (Auth::user()->role->name !== 'Admin') {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki otoritas mengakses halaman ini.');
        }

        $users = User::with('role')->latest()->get();
        $roles = \App\Models\Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function destroy(string $id)
    {
        if (Auth::user()->role->name !== 'Admin') {
            return redirect()->back()->with('error', 'Akses Ditolak!');
        }

        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Tindakan Ilegal: Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus dari sistem!');
    }

    public function update(Request $request, string $id)
    {
        if (Auth::user()->role->name !== 'Admin') {
            return redirect()->back()->with('error', 'Akses Ditolak!');
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('success', "Role akun {$user->name} berhasil diperbarui!");
    }
}