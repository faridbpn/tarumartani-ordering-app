<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Models\MenuItem;

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
        $categories = Category::all(); // Contoh, sesuaikan dengan model Anda
        $menuItems = MenuItem::with('category')->get(); // Contoh, sesuaikan dengan model Anda
        return view('userReservation', compact('categories', 'menuItems'));
    }
    
    // Fungsi untuk menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('register'); 
    }

    // Fungsi untuk menyimpan data pengguna baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set role default sebagai user
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}