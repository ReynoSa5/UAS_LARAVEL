<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TableUser;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = TableUser::query();
        if ($request->has('q') && $request->q != '') {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "$q%")
                    ->orWhere('username', 'like', "$q%");
            });
        }
        $users = $query->get();
        return view('admin.kelola-user', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_user' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'username' => 'required|unique:table_users,username',
            'password' => 'required',
        ]);
        $validated['password'] = bcrypt($validated['password']);

        TableUser::create($validated);
        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $user = TableUser::findOrFail($request->id_user);
        $validated = $request->validate([
            'id_user' => 'required|exists:table_users,id_user',
            'tipe_user' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'username' => 'required|unique:table_users,username,' . $user->id_user . ',id_user',
        ]);
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }
        $user->update($validated);
        return redirect()->back()->with('success', 'User berhasil diupdate');
    }

    public function destroy(Request $request)
    {
        $user = TableUser::findOrFail($request->id_user);
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
