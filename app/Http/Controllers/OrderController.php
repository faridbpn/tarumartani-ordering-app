<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items.menu')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $stats = [
            'total' => Order::count(),
            'new' => Order::where('status', 'new')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'revenue' => Order::where('status', 'completed')->sum('total_amount')
        ];

        return view('adminPage', compact('orders', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'total_amount' => $total,
            'status' => 'new'
        ]);

        foreach ($cart as $menuId => $item) {
            $order->items()->create([
                'menu_id' => $menuId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        Session::forget('cart');
        
        return redirect()->route('orders.success', $order);
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
        return redirect()->back()->with('success', 'Item added to cart successfully');
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
