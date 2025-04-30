<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['Items.menuItem'])
            ->orderBy('created_at', 'desc');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('Items.menuItem', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->query('status')) {
            if ($status !== 'All') {
                $query->where('status', $status);
            }
        }

        $orders = $query->get(); // Changed from paginate() to get()

        $totalOrders = Order::count();
        $newOrders = Order::where('status', 'Pending')->count();
        $processingOrders = Order::where('status', 'Processing')->count();
        $completedOrders = Order::where('status', 'Completed')->count();
        $totalRevenue = Order::where('status', 'Completed')->sum('total_amount');

        return view('orders', compact(
            'orders', 'totalOrders', 'newOrders', 'processingOrders', 'completedOrders', 'totalRevenue'
        ));
    }

    public function create()
    {
        $menuItems = MenuItem::all();
        return view('orders.create', compact('menuItems'));
    }

    public function dashboard()
    {
        return view('adminPage');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|string|max:50',
            'cart_items' => 'required',
        ]);

        // Parse cart items
        $cartItems = json_decode($request->cart_items, true);
        if (empty($cartItems)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        // Calculate totals
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
        $tax = 0.1 * $subtotal;
        $service = 0.05 * $subtotal;
        $total = $subtotal + $tax + $service;

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id() ?? 1,
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'total_amount' => $total,
            'status' => 'Pending',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        Session::forget('cart');

        return response()->json([
            'message' => 'Order placed successfully!',
            'order_id' => $order->id,
            'redirect' => route('home'),
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $menuItem = MenuItem::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('orders.create')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,On Delivery,Completed,Cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    // Archive 🔏
    public function archive(Order $order, Request $request)
    {
        $request->validate([
            'archive_status' => 'required|string|in:completed,canceled,failed',
            'archive_reason' => 'required|string'
        ]);

        $order->update([
            'archived_at' => now(),
            'archive_status' => $request->archive_status,
            'archive_reason' => $request->archive_reason
        ]);

        return redirect()->back()->with('success', 'Order has been archived successfully.');
    }
}
