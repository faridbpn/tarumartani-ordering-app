<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\MenuItem;

class UserController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $menuItems = Menu::with('category')->where('is_available', true)->orderBy('name')->get();

        return view('userPage', compact('categories', 'menuItems'));
    }
    public function reservation()
    {
        $categories = Category::all(); // Contoh, sesuaikan dengan model Anda
        $menuItems = MenuItem::with('category')->get(); // Contoh, sesuaikan dengan model Anda
        return view('userReservation', compact('categories', 'menuItems'));
    }
} 