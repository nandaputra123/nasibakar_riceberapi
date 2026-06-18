<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        // Jika sudah login, redirect ke home atau admin
        if (session('user_id')) {
            return session('user_role') === 'admin' 
                ? redirect('/admin/dashboard') 
                : redirect('/');
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan password benar
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah');
        }

        // Simpan data user ke session
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
        ]);

        // Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
        }

        return redirect('/')->with('success', 'Login berhasil!');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        // Jika sudah login, redirect ke home
        if (session('user_id')) {
            return redirect('/');
        }

        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // Buat user baru dengan role customer
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Redirect ke halaman login setelah berhasil register
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda');
    }

    // Proses logout
    public function logout()
    {
        // Hapus semua session
        session()->flush();

        return redirect('/login')->with('success', 'Logout berhasil');
    }
}
