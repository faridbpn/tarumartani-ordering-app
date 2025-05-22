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
            Log::info('Store method called', ['request' => $request->all(), 'hasFile' => $request->hasFile('image')]);
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'is_available' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed', ['errors' => $validator->errors()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->only(['name', 'description', 'price', 'category_id', 'is_available']);

            if ($request->hasFile('image')) {
                Log::info('Image detected in request', ['file' => $request->file('image')]);
                if ($request->file('image')->isValid()) {
                    try {
                        $originalName = $request->file('image')->getClientOriginalName();
                        $path = $request->file('image')->store('menus', 'public');
                        Log::info('Image stored', ['path' => $path, 'originalName' => $originalName]);
                        if (!$path) {
                            throw new \Exception('Failed to store image: Storage path returned empty');
                        }
                        $data['image'] = $path;
                    } catch (\Exception $e) {
                        Log::error('Image upload failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to upload image: ' . $e->getMessage()
                        ], 500);
                    }
                } else {
                    Log::error('Invalid image file', ['error' => $request->file('image')->getErrorMessage()]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid image file: ' . $request->file('image')->getErrorMessage()
                    ], 422);
                }
            } else {
                Log::info('No image file in request');
            }

            $menu = Menu::create($data);
            Log::info('Menu created', ['menu' => $menu]);

            return response()->json([
                'success' => true,
                'message' => 'Menu created successfully',
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            Log::error('Menu creation failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create menu: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function update(Request $request, $id)
    {
        try {
            Log::info('Update method called', [
                'menu_id' => $id,
                'request_data' => $request->all(),
                'has_file' => $request->hasFile('image'),
                'file_input' => $request->file('image') ? [
                    'name' => $request->file('image')->getClientOriginalName(),
                    'size' => $request->file('image')->getSize(),
                    'type' => $request->file('image')->getMimeType(),
                    'error' => $request->file('image')->getError()
                ] : null
            ]);
    
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
                Log::error('Validation failed', ['errors' => $validator->errors()->toArray()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $data = $request->only(['name', 'description', 'price', 'category_id', 'is_available']);
    
            if ($request->hasFile('image')) {
                Log::info('Image detected in request');
                if ($request->file('image')->isValid()) {
                    try {
                        if ($menu->image) {
                            Log::info('Deleting old image', ['old_image' => $menu->image]);
                            Storage::disk('public')->delete($menu->image);
                        }
                        $originalName = $request->file('image')->getClientOriginalName();
                        $fileSize = $request->file('image')->getSize();
                        $fileType = $request->file('image')->getMimeType();
                        Log::info('Attempting to store image', [
                            'original_name' => $originalName,
                            'size' => $fileSize,
                            'type' => $fileType
                        ]);
    
                        // Uji apakah disk public dapat diakses
                        if (!Storage::disk('public')->exists('menus')) {
                            Log::info('Creating menus directory');
                            Storage::disk('public')->makeDirectory('menus');
                        }
    
                        $path = $request->file('image')->store('menus', 'public');
                        Log::info('Image store result', ['path' => $path]);
    
                        if (!$path) {
                            throw new \Exception('Failed to store image: Storage path returned empty');
                        }
                        $data['image'] = $path;
                    } catch (\Exception $e) {
                        Log::error('Image upload failed', [
                            'message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to upload image: ' . $e->getMessage()
                        ], 500);
                    }
                } else {
                    Log::error('Invalid image file', [
                        'error' => $request->file('image')->getErrorMessage(),
                        'error_code' => $request->file('image')->getError()
                    ]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid image file: ' . $request->file('image')->getErrorMessage()
                    ], 422);
                }
            } else {
                Log::info('No image file in request');
            }
    
            $menu->update($data);
            Log::info('Menu updated', ['menu' => $menu->toArray()]);
    
            return response()->json([
                'success' => true,
                'message' => 'Menu updated successfully',
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            Log::error('Menu update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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