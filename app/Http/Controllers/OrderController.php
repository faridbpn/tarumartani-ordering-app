<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        try {
            DB::beginTransaction();

            // Get JSON input
            $input = $request->json()->all();

            // Validate the request
            $validator = Validator::make($input, [
                'customer_name' => 'required|string|max:255',
                'table_number' => 'required|string|max:50',
                'items' => 'required|array',
                'items.*.id' => 'required|integer|exists:menus,id',
                'items.*.quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $totalAmount = 0;
            $orderItems = [];

            // Calculate total amount and prepare order items
            foreach ($input['items'] as $item) {
                $menuItem = MenuItem::findOrFail($item['id']);
                if (!$menuItem->is_available) {
                    throw new \Exception("Menu item {$menuItem->name} is not available");
                }
                $subtotal = $menuItem->price * $item['quantity'];
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'menu_id' => $item['id'],
                    'name' => $menuItem->name,
                    'quantity' => $item['quantity'],
                    'price' => $menuItem->price,
                    'subtotal' => $subtotal
                ];
            }

            // Calculate tax and service charge
            $tax = $totalAmount * 0.1;
            $service = $totalAmount * 0.05;
            $total = $totalAmount + $tax + $service;

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id() ?? 1,
                'customer_name' => $input['customer_name'],
                'table_number' => $input['table_number'],
                'total_amount' => $total,
                'status' => 'Pending',
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order has been placed successfully!',
                'order_id' => $order->id
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'One or more menu items not found'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function addToCart(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $id = $menuItem->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }

    public function updateCart(Request $request, MenuItem $menuItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);
        $id = $menuItem->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function removeFromCart(MenuItem $menuItem)
    {
        $cart = Session::get('cart', []);
        $id = $menuItem->id;

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function showCart()
    {
        $cart = Session::get('cart', []);
        return view('cart', compact('cart'));
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
