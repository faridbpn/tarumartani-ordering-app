<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('loginPage');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // dd($request);
        if (Auth::attempt(credentials: $request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah.'
        ]);
    }

    public function dashboard()
    {
        $totalOrders = Order::count();
        $newOrders = Order::where('status', 'new')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');

        return view('adminPage', compact(
            'totalOrders',
            'newOrders',
            'processingOrders',
            'completedOrders',
            'totalRevenue'
        ));
    }

    public function logout()
    {
        return redirect()->route('login');
    }
}
