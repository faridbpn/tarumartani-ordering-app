<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Menu::with('category')->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }
        
        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_available', $request->status);
        }
        
        $menus = $query->paginate(6);
        $categories = Category::all();
        
        return view('menuItems', compact('menus', 'categories', 'user'));
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'is_available' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->only(['name', 'description', 'price', 'category_id', 'is_available']);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $path = $request->file('image')->store('menus', 'public');
                if ($path) {
                    $data['image'] = $path;
                }
            }

            $menu = Menu::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Menu created successfully',
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            Log::error('Menu creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create menu: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function update(Request $request, $id)
    {
        try {
            $menu = Menu::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'is_available' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            $data = $request->only(['name', 'description', 'price', 'category_id', 'is_available']);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image if exists
                if ($menu->image) {
                    Storage::disk('public')->delete($menu->image);
                }
                
                $path = $request->file('image')->store('menus', 'public');

                // dd($path);

                if ($path) {
                    $data['image'] = $path;
                }
            }

            $menu->update($data);

            return response()->json([
                'success' => true, 
                'message' => 'Menu updated successfully',
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            Log::error('Menu update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update menu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return response()->json(['success' => true, 'message' => 'Menu deleted successfully']);
    }
}