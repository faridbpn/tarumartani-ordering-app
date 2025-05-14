<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class UserController extends Controller
{
    public function index()
    {
        
        $categories = Category::all();
        $menuItems = Menu::with('category')->where('is_available', true)->orderBy('name')->get();

        return view('userReservation', compact('categories', 'menuItems'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->where('role', 'user')->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('userReservation');
        } else {
            return back()->with('error', 'Email atau password salah, atau Anda bukan user.');
        }
    }
    
    public function reservation()
    {
        $categories = Category::all();
        $menuItems = Menu::with('category')->where('is_available', true)->orderBy('name')->get();
    
        return view('userReservation', compact('categories', 'menuItems'));
    }
    
    
} 