<?php

namespace App\Http\Controllers;

use App\Models\TableLog;
use App\Models\TableUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function login_user(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $r = TableUser::where('username', $request->username)->first();

        if ($r && Hash::check($request->password, $r->password)) {
            Auth::guard('usep')->login($r);
            TableLog::create([
                'waktu' => now(),
                'aktivitas' => 'Login',
                'id_user' => $r->id_user
            ]);
            if ($r->tipe_user === 'gudang') {
                return redirect(url('gudang/kelola-barang'));
            }
            if ($r->tipe_user === 'kasir') {
                return redirect(url('kasir/kelola-transaksi'));
            }
            return redirect('admin/log');
        }


        return back()->with('pesan', 'Username atau password salah');
    }

    public function log(Request $request)
    {
        $logs = TableLog::with('user')->orderByDesc('waktu');
        if ($request->filled('tanggal')) {
            $logs->whereDate('waktu', $request->tanggal);
        }
        $logs = $logs->get();
        return view('admin.log_aktivitas', compact('logs'));
    }

    public function logout()
    {
        $userId = session('kartu');
        if (!$userId && Auth::guard('usep')->check()) {
            $userId = Auth::guard('usep')->user()->id_user;
        }
        if ($userId) {
            TableLog::create([
                'waktu' => now(),
                'aktivitas' => 'Logout',
                'id_user' => $userId,
            ]);
        }
        Auth::guard('usep')->logout();
        return redirect(url('login'));
    }

    public function index()
    {
        return view('admin.kelola-laporan');
    }
    public function kelolaBarang()
    {
        return view('gudang.kelola-barang');
    }
    public function kelolaTransaksi()
    {
        return view('kasir.kelola-transaksi');
    }
}
