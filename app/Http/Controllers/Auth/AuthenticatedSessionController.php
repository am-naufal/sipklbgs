<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        } elseif ($user->role === 'pembimbing') {
            return redirect()->route('pembimbing.dashboard');
        } elseif ($user->role === 'kepala_sekolah') {
            return redirect()->route('kepala_sekolah.dashboard');
        } elseif ($user->role === 'industri') {
            return redirect()->route('industri.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors(['role' => 'Role tidak dikenali']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
