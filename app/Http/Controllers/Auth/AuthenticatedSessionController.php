<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $categories = Product_category::with('translations')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks')->where('status', 'active')->get();
        return view('auth.login', compact('categories', 'brands', 'products'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Find user by email
        $user = \App\Models\User::where('email', $request->email)->first();

        // Email not found
        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email address.'])->withInput();
        }

        // Incorrect password
        if (!\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password. Please try again.'])->withInput();
        }

        // Login user
        \Auth::login($user);
        $request->session()->regenerate();

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->intended('admin/dashboard')->with('success', 'Welcome back, Admin!');
        } elseif ($user->role === 'user') {
            return redirect()->intended('/user-dashboard')->with('success', 'Login successful!');
        } else {
            return redirect()->intended('/')->with('success', 'Logged in successfully!');
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
