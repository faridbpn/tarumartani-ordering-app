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

        // Sorting
        if ($request->sort) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('archived_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('archived_at', 'asc');
                    break;
                case 'highest':
                    $query->orderBy('total_amount', 'desc');
                    break;
                case 'lowest':
                    $query->orderBy('total_amount', 'asc');
                    break;
                default:
                    $query->orderBy('archived_at', 'desc');
            }
        } else {
            $query->orderBy('archived_at', 'desc');
        }

        $archivedOrders = $query->paginate(10)->withQueryString();

        return view('arsip', compact('archivedOrders'));
    }

    public function export(Request $request)
    {
        $query = Order::with(['items.menuItem', 'user'])
            ->whereNotNull('archived_at');

        // Apply the same filters as the index page
        if ($request->tab && $request->tab !== 'all') {
            $query->where('archive_status', strtolower($request->tab));
        }

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

        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

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

        // Apply sorting
        if ($request->sort) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('archived_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('archived_at', 'asc');
                    break;
                case 'highest':
                    $query->orderBy('total_amount', 'desc');
                    break;
                case 'lowest':
                    $query->orderBy('total_amount', 'asc');
                    break;
                default:
                    $query->orderBy('archived_at', 'desc');
            }
        } else {
            $query->orderBy('archived_at', 'desc');
        }

        $data = $query->get();
        
        // Get filter information for PDF header
        $filterInfo = [
            'tab' => $request->tab ? ucfirst($request->tab) : 'All',
            'date_range' => $this->getDateRangeText($request->date_range),
            'payment_method' => $request->payment_method ? ucfirst($request->payment_method) : 'All',
            'search' => $request->search,
            'sort' => $this->getSortText($request->sort),
            'total_orders' => $data->count(),
            'total_amount' => $data->sum('total_amount'),
            'generated_at' => now()->format('d M Y H:i:s')
        ];

        $pdf = PDF::loadView('pdf.archive', compact('data', 'filterInfo'));
        $pdf->setPaper('A4', 'portrait');
        
        // Add metadata to PDF
        $pdf->setOption('title', 'Order Archive Report');
        $pdf->setOption('author', 'Tarumartani App');
        $pdf->setOption('subject', 'Order Archive Report ' . now()->format('d M Y'));
        
        return $pdf->download('order-archive-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function getDateRangeText($dateRange)
    {
        switch ($dateRange) {
            case 'today':
                return 'Today';
            case 'last7days':
                return 'Last 7 Days';
            case 'last30days':
                return 'Last 30 Days';
            default:
                return 'All Time';
        }
    }

    private function getSortText($sort)
    {
        switch ($sort) {
            case 'newest':
                return 'Newest First';
            case 'oldest':
                return 'Oldest First';
            case 'highest':
                return 'Highest Amount';
            case 'lowest':
                return 'Lowest Amount';
            default:
                return 'Newest First';
        }
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