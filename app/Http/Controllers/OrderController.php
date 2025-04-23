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
        $orders = Order::with('items')->latest()->get();
        return view('orders', compact('orders'));
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
        // Validasi input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|string|max:10',
        ]);

        // Simpan pesanan
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'total' => 0, // Total akan dihitung setelah menyimpan item
            'status' => 'pending',
        ]);

        // Ambil data cart dari session atau frontend (sesuaikan dengan logika Anda)
        $cart = session('cart', []); // Contoh: jika cart disimpan di session
        $subtotal = 0;

        foreach ($cart as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Hitung pajak dan biaya layanan
        $tax = $subtotal * 0.1;
        $service = $subtotal * 0.05;
        $total = $subtotal + $tax + $service;

        // Update total pada order
        $order->update(['total' => $total]);

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil ditempatkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

      /**
     * menampilkan order yang sudah selesai⚠️.
     */
    public function arsip()
    {
        $orders = Order::with('items.menu')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('arsip', compact('orders'));
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
event(new \App\Events\OrderPlaced($order));