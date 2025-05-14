<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

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

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check user role and redirect accordingly
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('userReservation');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.'
        ]);
    }

    public function dashboard(Request $request)
    {
        // 1. Total Orders (Reset per bulan)
        $currentMonth = Carbon::now()->startOfMonth();
        $totalOrders = Order::where('created_at', '>=', $currentMonth)->count();

        // History Order per Bulan untuk Pop-up
        $orderHistory = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('F Y'),
                    'total' => $item->total,
                ];
            });

        // 2. Menu Favorit Bulanan
        $monthlyFavoriteMenu = OrderItem::select('menu_id', DB::raw('COUNT(*) as order_count'))
            ->where('created_at', '>=', $currentMonth)
            ->groupBy('menu_id')
            ->orderBy('order_count', 'desc')
            ->first();

        $favoriteMenu = null;
        $favoriteMenuCount = 0;
        if ($monthlyFavoriteMenu) {
            $favoriteMenu = Menu::find($monthlyFavoriteMenu->menu_id);
            $favoriteMenuCount = $monthlyFavoriteMenu->order_count;
        }

        // History Menu Favorit per Bulan untuk Pop-up
        $favoriteMenuHistory = OrderItem::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, menu_id, COUNT(*) as order_count')
            ->groupBy('year', 'month', 'menu_id')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::createFromDate($item->year, $item->month, 1)->format('Y-m');
            })
            ->map(function ($group) {
                $topMenu = $group->sortByDesc('order_count')->first();
                $menu = Menu::find($topMenu->menu_id);
                return [
                    'month' => Carbon::createFromDate($topMenu->year, $topMenu->month, 1)->format('F Y'),
                    'menu_name' => $menu ? $menu->name : 'N/A',
                    'order_count' => $topMenu->order_count,
                ];
            })->values();

        // 3. Total Menu Items
        $totalMenuItems = Menu::count();

        // 4. Diagram Total Orders (Harian, 30 Hari, 90 Hari)
        $filter = $request->input('filter', 'daily'); // Default: harian

        if ($filter === 'daily') {
            $startDate = Carbon::today();
            $labels = [Carbon::today()->format('M d')];
            $data = [Order::whereDate('created_at', $startDate)->count()];
        } elseif ($filter === 'last30days') {
            $startDate = Carbon::now()->subDays(30);
            $orders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->where('created_at', '>=', $startDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $labels = [];
            $data = [];
            for ($date = $startDate; $date <= Carbon::today(); $date->addDay()) {
                $labels[] = $date->format('M d');
                $order = $orders->firstWhere('date', $date->toDateString());
                $data[] = $order ? $order->total : 0;
            }
        } else { // last90days
            $startDate = Carbon::now()->subDays(90);
            $orders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->where('created_at', '>=', $startDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $labels = [];
            $data = [];
            for ($date = $startDate; $date <= Carbon::today(); $date->addDay()) {
                $labels[] = $date->format('M d');
                $order = $orders->firstWhere('date', $date->toDateString());
                $data[] = $order ? $order->total : 0;
            }
        }

        // 5. Pie Chart: 3 Menu Favorit Sepanjang Masa
        $topMenus = OrderItem::select('menu_id', DB::raw('COUNT(*) as order_count'))
            ->groupBy('menu_id')
            ->orderBy('order_count', 'desc')
            ->take(3)
            ->get();

        $pieLabels = [];
        $pieData = [];
        foreach ($topMenus as $menu) {
            $menuItem = Menu::find($menu->menu_id);
            $pieLabels[] = $menuItem ? $menuItem->name : 'Unknown';
            $pieData[] = $menu->order_count;
        }

        return view('adminPage', compact(
            'totalOrders',
            'orderHistory',
            'favoriteMenu',
            'favoriteMenuCount',
            'favoriteMenuHistory',
            'totalMenuItems',
            'filter',
            'labels',
            'data',
            'pieLabels',
            'pieData'
        ));
    }
    
    // AdminController.php
    public function redirectAfterLogin()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda belum login.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('userReservation');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}