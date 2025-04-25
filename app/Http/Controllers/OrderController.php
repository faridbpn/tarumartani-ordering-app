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
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|integer',
        ]);
    
        $cart = session()->get('cart', []);
    
        if (empty($cart)) {
            return redirect()->route('orders.create')->with('error', 'Keranjang pesanan kosong.');
        }
    
        DB::beginTransaction();
    
        try {
            // Buat pesanan baru
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'status' => 'Pending',
                'total_amount' => 0
            ]);
    
            $totalAmount = 0;
    
            // Tambahkan detail pesanan     
            foreach ($cart as $itemId => $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $totalAmount += $itemTotal;
    
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $itemId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $itemTotal,
                ]);
            }
    
            // (Opsional) Tambahkan pajak dan service charge jika diperlukan
            $tax = $totalAmount * 0.1;
            $service = $totalAmount * 0.05;
            $finalTotal = $totalAmount + $tax + $service;
    
            // Update total di tabel orders
            $order->update([
                'total_amount' => $totalAmount // ganti dengan $finalTotal jika pakai pajak
            ]);
    
            DB::commit();
    
            // Kosongkan keranjang
            session()->forget('cart');
    
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->route('orders.create')->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }
    }    

     /**
     * Public function addToCart.
     */
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
}
