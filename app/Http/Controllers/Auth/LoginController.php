<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminModel;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $this->validate($request, [
        'username' => 'required|string',
        'password' => 'required|string',
    ], [
        'username.required' => 'Username wajib di isi.',
        'password.required' => 'Password wajib di isi'
    ]);

    $credentials = $request->only('username', 'password');

    // Cek apakah username ada
    $user = AdminModel::where('username', $credentials['username'])->first();
    if(!$user) {
        return redirect('/login')->with('error', 'Username tida dapat ditemukan');
    }

    if ($user) {
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->put('admin_name', $user->name);
            $request->session()->flash('success', 'Login berhasil! Selamat datang, ' . $user->name . '.');
            return redirect("/");
        } else {
            return redirect()->back()->with('error', 'Password yang Anda masukkan salah.');
        }
    } else {
        return redirect()->back()->with('error', 'Username tidak ditemukan.');
    }
}

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus nama pengguna dari session
        $request->session()->forget('admin_name');

        // Menyimpan pesan sukses ke session
        $request->session()->flash('success', 'Anda telah berhasil logout.');

        // Redirect ke halaman login
        return redirect('/login');
    }
}