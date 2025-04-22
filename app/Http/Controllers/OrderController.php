<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\MenuItem;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalOrders = Order::count();
        $newOrders = Order::where('status', 'new')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        $recentOrders = Order::with('orderItems.menu')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('orders', compact(
            'totalOrders',
            'newOrders',
            'processingOrders',
            'completedOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

     /**
     * public function dashboard.
     */
    public function dashboard()
    {
        return view('adminPage');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'status' => 'new',
                'total_amount' => 0
            ]);

            $totalAmount = 0;
            foreach ($request->items as $item) {
                $menuItem = MenuItem::find($item['id']);
                $order->items()->create([
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $menuItem->price
                ]);
                $totalAmount += $menuItem->price * $item['quantity'];
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('orders.success', $order)
                ->with('success', 'Order has been placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function success(Order $order)
    {
        return view('orderSuccess', compact('order'));
    }

    public function archive()
    {
        $orders = Order::with('items.menu')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orderArchive', compact('orders'));
    }

    public function addToCart(Request $request, Menu $menu)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] += $request->quantity;
        } else {
            $cart[$menu->id] = [
                'name' => $menu->name,
                'quantity' => $request->quantity,
                'price' => $menu->price,
                'image' => $menu->image
            ];
        }
        
        Session::put('cart', $cart);
        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully'
        ]);
        
    }

    public function updateCart(Request $request, Menu $menu)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully');
        }
        
        return redirect()->back()->with('error', 'Item not found in cart');
    }

    public function removeFromCart(Menu $menu)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$menu->id])) {
            unset($cart[$menu->id]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed from cart');
        }
        
        return redirect()->back()->with('error', 'Item not found in cart');
    }

    public function showCart()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart', compact('cart', 'total'));
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('menu.public')->with('error', 'Your cart is empty');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
    }
}
