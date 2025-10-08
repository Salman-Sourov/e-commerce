<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Models\Product_category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class UserController extends Controller
{
    // public function home()
    // {
    //     $categories = Product_category::with('translations')->where('status', 'active')->get();
    //     $brands = Brand::with('translations')->where('status', 'active')->get();
    //     $products = Product::with('translations', 'inventory_stocks')->where('status', 'active')->get();
    //     return view('frontend.index', compact('categories', 'brands', 'products'));
    // }
    // public function index()
    // {
    //     $categories = Product_category::with('translations')->where('status', 'active')->get();
    //     $brands = Brand::with('translations')->where('status', 'active')->get();
    //     $products = Product::with('translations', 'inventory_stocks')->where('status', 'active')->get();
    //     return view('index', compact('categories', 'brands', 'products'));
    // }


    public function userDashboard()
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $auth = Auth::user();
        $carts = session()->get('cart'); // Default to an empty array if no cart exists

        $orders = Order::with('product')->where('user_id', $auth->id)->orderBy('created_at', 'desc')->get();
        // dd($orders);

        return view('frontend.user_dashboard', compact('categories', 'brands', 'products', 'auth', 'orders', 'carts'));
    }
    public function userLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Get the currently logged-in user

        // --- Dynamic Validation Rules ---
        $rules = [];

        // Validate only the fields that are present
        if ($request->filled('phone')) {
            $rules['phone'] = 'string|max:255|unique:users,phone,' . $user->id;
        }

        if ($request->filled('email')) {
            $rules['email'] = 'email|max:255|unique:users,email,' . $user->id;
        }

        if ($request->filled('address')) {
            $rules['address'] = 'string|max:255';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        // Validate request with dynamic rules
        $validatedData = $request->validate($rules);

        // --- Update only the provided fields ---
        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('address')) {
            $user->address = $request->address;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save updated data
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
