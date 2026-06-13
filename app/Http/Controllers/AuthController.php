<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (auth()->user()->role == 'enseignant') {
            return redirect()->route('enseignant.dashboard');
        }

        if (auth()->user()->role == 'etudiant') {
            return redirect()->route('etudiant.dashboard');
        }

        abort(403);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (auth()->user()->role == 'enseignant') {
                return redirect()->route('enseignant.dashboard');
            }

            if (auth()->user()->role == 'etudiant') {
                return redirect()->route('etudiant.dashboard');
            }

            abort(403);
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('accueil');
    }
}
