<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Engagement;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     */

    public function login()
    {

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        $totalClients = Client::count();

        $totalOpenEngagements = Engagement::where('status', 'Open')->count();

        $upcomingEngagements = Engagement::with('client')
            ->whereIn('status', ['Open', 'In Progress'])
            ->whereDate('due_date', '>=', today())
            ->orderBy('due_date')
            ->take(3)
            ->get();

        $activeClients = Client::where('status', 'Active')->count();

        $recentClients = Client::latest()
            ->take(5)
            ->get();

        return view('auth.dashboard', compact(
            'totalClients',
            'activeClients',
            'recentClients',
            'totalOpenEngagements',
            'upcomingEngagements',
        ));
    }
}
