<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('daftar');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nama_belakang' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'tujuan' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms' => ['accepted'],
        ]);

        $fullName = trim($validated['nama'].' '.($validated['nama_belakang'] ?? ''));

        $user = User::create([
            'name' => $fullName,
            'email' => $validated['email'],
            'class_level' => $validated['kelas'] ?? null,
            'learning_goal' => $validated['tujuan'] ?? null,
            'password' => $validated['password'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat. Selamat datang di SoftiFY!');
=======
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/auth')->with('success', 'Register berhasil!');
>>>>>>> 02419d06a0ab67eef11f7cdc62efad154ccf90c7
    }

    public function login(Request $request)
    {
<<<<<<< HEAD
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withInput()->withErrors([
                'email' => 'Email atau kata sandi tidak valid.',
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->is_banned) {
            Auth::logout();

            return back()->withInput()->withErrors([
                'email' => 'Akun kamu sedang diblokir oleh admin.',
            ]);
        }

        $request->session()->regenerate();

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
=======
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/page');
        }

        return back()->with('error', 'Login gagal!');
    }
}
>>>>>>> 02419d06a0ab67eef11f7cdc62efad154ccf90c7
