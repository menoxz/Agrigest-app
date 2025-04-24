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

        // Debug logs
        \Log::info('User authenticated', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'role_id' => auth()->user()->role_id,
            'role' => auth()->user()->role ? auth()->user()->role->nom_role : 'No role',
        ]);

        if (auth()->user()->role && auth()->user()->role->nom_role === 'admin') {
            \Log::info('Redirecting admin to admin dashboard');
            return redirect()->intended('/admin/dashboard');
        }

        Tests-unitaires
        \Log::info('Redirecting user to user dashboard');
        return redirect()->intended('/dashboard');

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
