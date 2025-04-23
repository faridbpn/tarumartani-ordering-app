<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $menuItems = Menu::with('category')->where('is_available', true)->orderBy('name')->get();

        return view('userPage', compact('categories', 'menuItems'));
    }
} 