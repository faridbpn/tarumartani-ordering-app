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
            ->whereNull('archived_at')
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

        $orders = $query->get();

        $totalOrders = Order::whereNull('archived_at')->count();
        $newOrders = Order::where('status', 'Pending')->whereNull('archived_at')->count();
        $processingOrders = Order::where('status', 'Processing')->whereNull('archived_at')->count();
        $completedOrders = Order::where('status', 'Completed')->whereNull('archived_at')->count();
        $totalRevenue = Order::where('status', 'Completed')->whereNull('archived_at')->sum('total_amount');

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
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }
      
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

    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
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

        return view('arsip', compact('orders'));
    }

    /**
     * Cart management functions remain unchanged...
     */
    public function addToCart(Request $request, MenuItem $menuItem)
    {
        $cart = Session::get('cart', []);

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
            'archive_reason' => 'required|string'
        ]);

        $order->update([
            'archived_at' => now(),
            'archive_status' => strtolower($order->status),
            'archive_reason' => $request->archive_reason
        ]);

        return redirect()->back()->with('success', 'Order has been archived successfully.');
    }

    public function deleteArchive(Order $order)
    {
        $order->delete();
        return redirect()->back()->with('success', 'Archived order has been deleted successfully.');
    }

    public function showDetails(Order $order)
    {
        return response()->json([
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'table_number' => $order->table_number,
            'status' => $order->status,
            'created_at' => $order->created_at,
            'total_amount' => $order->total_amount,
            'items' => $order->Items->map(function ($item) {
                return [
                    'menu_item' => [
                        'name' => $item->menuItem->name,
                    ],
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal
                ];
            })
        ]);
    }
}
