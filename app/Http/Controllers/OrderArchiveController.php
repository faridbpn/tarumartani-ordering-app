<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderArchiveController extends Controller
{
    public function index()
    {
        $archivedOrders = Order::with(['items.menuItem', 'user'])
            ->whereNotNull('archived_at')
            ->orderBy('archived_at', 'desc')
            ->paginate(10);

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