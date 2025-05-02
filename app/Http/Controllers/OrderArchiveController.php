<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderArchiveController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items.menuItem', 'user'])
            ->whereNotNull('archived_at');

        // Tab filtering
        if ($request->tab && $request->tab !== 'all') {
            $query->where('archive_status', strtolower($request->tab));
        }

        // Date filtering
        if ($request->date_range) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('archived_at', today());
                    break;
                case 'last7days':
                    $query->where('archived_at', '>=', now()->subDays(7));
                    break;
                case 'last30days':
                    $query->where('archived_at', '>=', now()->subDays(30));
                    break;
            }
        }

        // Payment method filtering
        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('items.menuItem', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $archivedOrders = $query->orderBy('archived_at', 'desc')
                               ->paginate(10)
                               ->withQueryString();

        return view('arsip', compact('archivedOrders'));
    }

    public function export()
    {
            $data = Order::whereNotNull('archived_at')
                ->orderBy('archived_at', 'desc')
                ->with(['user', 'items.menuItem'])
                ->get();
    
            $pdf = Pdf::loadView('pdf.arcive', compact('data'));
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('margin-top', 20);
            $pdf->setOption('margin-bottom', 20);
            $pdf->setOption('margin-left', 20);
            $pdf->setOption('margin-right', 20);
        
            return $pdf->download('arsip-orders.pdf');
    }

    public function archive(Order $order, Request $request)
    {
        $request->validate([
            'archive_reason' => 'required|string',
            'archive_status' => 'required|string|in:completed,canceled,failed'
        ]);

        $order->update([
            'archived_at' => now(),
            'archive_reason' => $request->archive_reason,
            'archive_status' => $request->archive_status
        ]);

        return redirect()->back()->with('success', 'Order has been archived successfully.');
    }

    public function restore(Order $order)
    {
        $order->update([
            'archived_at' => null,
            'archive_reason' => null,
            'archive_status' => null
        ]);

        return redirect()->back()->with('success', 'Order has been restored successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->back()->with('success', 'Order has been permanently deleted.');
    }
}