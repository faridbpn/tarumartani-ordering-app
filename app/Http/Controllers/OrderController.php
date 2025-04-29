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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('orderItems.menuItem')
            ->orderBy('created_at', 'desc');

        // Pencarian berdasarkan customer_name, id, atau nama item
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhereHas('orderItems.menuItem', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan status
        if ($status = $request->query('status')) {
            if ($status !== 'All') {
                $query->where('status', $status);
            }
        }

        $orders = $query->paginate(12)->appends($request->query());

        // Data untuk dashboard (opsional, jika masih dibutuhkan)
        $totalOrders = Order::count();
        $newOrders = Order::where('status', 'Pending')->count();
        $processingOrders = Order::where('status', 'Processing')->count();
        $completedOrders = Order::where('status', 'Completed')->count();
        $totalRevenue = Order::where('status', 'Completed')->sum('total_amount');

        return view('orders', compact(
            'orders',
            'totalOrders',
            'newOrders',
            'processingOrders',
            'completedOrders',
            'totalRevenue'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuItems = MenuItem::all();
        return view('orders.create', compact('menuItems'));
    }

    /**
     * Public function dashboard.
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
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
    
        DB::beginTransaction();
    
        try {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'status' => 'Pending',
                'total_amount' => 0
            ]);
    
            $totalAmount = 0;
    
            foreach ($request->items as $item) {
                $menuItem = MenuItem::find($item['id']);
                $order->orderItems()->create([
                    'menu_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $menuItem->price
                ]);
                $totalAmount += $menuItem->price * $item['quantity'];
            }
    
            // Hitung pajak dan biaya layanan
            $tax = $totalAmount * 0.1;
            $service = $totalAmount * 0.05;
            $total = $totalAmount + $tax + $service;
    
            // Update total pada order
            $order->update(['total_amount' => $total]);
    
            DB::commit();
    
            return redirect()->route('orders.success', $order)
                ->with('success', 'Order has been placed successfully!');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Completed,On Delivery,Cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    /**
     * Display completed orders.
     */
    public function archive()
    {
        $orders = Order::with('orderItems.menuItem')
            ->where('status', 'Completed')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orderArchive', compact('orders'));
    }

    /**
     * Cart management functions remain unchanged...
     */
    public function addToCart(Request $request, MenuItem $menuItem)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$menuItem->id])) {
            $cart[$menuItem->id]['quantity'] += $request->quantity;
        } else {
            $cart[$menuItem->id] = [
                'name' => $menuItem->name,
                'quantity' => $request->quantity,
                'price' => $menuItem->price,
                'image' => $menuItem->image
            ];
        }

        Session::put('cart', $cart);
        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully'
        ]);
    }

    public function updateCart(Request $request, MenuItem $menuItem)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$menuItem->id])) {
            $cart[$menuItem->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully');
        }

        return redirect()->back()->with('error', 'Item not found in cart');
    }

    public function removeFromCart(MenuItem $menuItem)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$menuItem->id])) {
            unset($cart[$menuItem->id]);
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

        return view('checkout', compact('cart', 'total'));
    }

    public function success(Order $order)
    {
        return view('orderSuccess', compact('order'));
    }
}
