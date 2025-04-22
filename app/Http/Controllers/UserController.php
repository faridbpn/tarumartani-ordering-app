<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $foods = Menu::where('category', 'food')
            ->where('is_available', true)
            ->orderBy('name')
            ->get();
            
        $beverages = Menu::where('category', 'beverage')
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return view('userPage', compact('foods', 'beverages'));
    }
} 