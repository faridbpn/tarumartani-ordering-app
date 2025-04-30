<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Archive - FoodExpress Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    @include('layouts.app')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="bg-white shadow-sm p-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-bold text-gray-800">Order Archive</h2>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-[#f6f8fb]">
            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow p-4 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-72">
                        <input type="text" id="searchInput" placeholder="Search archived orders..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-[#f6f8fb]">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="statusFilter" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-[#f6f8fb]">
                        <option value="all">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="on delivery">On Delivery</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button id="sortDate" class="px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-calendar-alt mr-2"></i>Sort by Date
                    </button>
                </div>
            </div>

            <!-- Archive List -->
            <div class="space-y-4">
                @forelse ($archives as $order)
                    <div class="archive-card bg-white rounded-2xl shadow-md border border-gray-100 p-6" 
                         data-status="{{ $order->archive_status }}"
                         data-date="{{ $order->archived_at }}"
                         data-search="{{ $order->customer_name }} {{ $order->id }} @foreach($order->items as $item) {{ $item->menuItem->name }} @endforeach">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-semibold text-gray-800">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                    <span class="status-badge px-3 py-1 rounded-lg text-sm font-medium
                                        @if($order->archive_status == 'completed') bg-green-100 text-green-700
                                        @elseif($order->archive_status == 'processing') bg-yellow-100 text-yellow-700
                                        @elseif($order->archive_status == 'on delivery') bg-blue-100 text-blue-700
                                        @elseif($order->archive_status == 'cancelled') bg-red-100 text-red-700
                                        @else bg-purple-100 text-purple-700 @endif">
                                        {{ ucfirst($order->archive_status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    Archived: {{ $order->archived_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <form action="{{ route('orders.deleteArchive', $order->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm flex items-center gap-2">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </form>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-medium text-gray-800">{{ $order->customer_name }}</h4>
                            <p class="text-sm text-gray-500">
                                Table #{{ $order->table_number }} - {{ $order->items->sum('quantity') }} items
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Reason: {{ $order->archive_reason }}
                            </p>
                        </div>

                        <div class="space-y-2 mb-4">
                            @foreach($order->items as $orderItem)
                                <div class="flex justify-between">
                                    <span class="text-gray-700">{{ $orderItem->menuItem->name }}</span>
                                    <span class="text-gray-700">{{ $orderItem->quantity }} x ${{ number_format($orderItem->price, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between border-t border-gray-100 pt-4">
                            <span class="font-medium text-gray-500">Total</span>
                            <span class="font-bold text-gray-800">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow p-8 text-center">
                        <i class="fas fa-archive text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-800">No Archived Orders</h3>
                        <p class="text-gray-500">There are currently no archived orders to display.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const archiveCards = document.querySelectorAll('.archive-card');
                
                archiveCards.forEach(card => {
                    const cardText = card.dataset.search.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Status filter functionality
            document.getElementById('statusFilter').addEventListener('change', function() {
                const status = this.value.toLowerCase();
                const archiveCards = document.querySelectorAll('.archive-card');
                
                archiveCards.forEach(card => {
                    const cardStatus = card.dataset.status;
                    if (status === 'all' || cardStatus === status) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Sort by date functionality
            let dateAscending = true;
            document.getElementById('sortDate').addEventListener('click', function() {
                const archiveCards = Array.from(document.querySelectorAll('.archive-card'));
                const container = document.querySelector('.space-y-4');
                
                archiveCards.sort((a, b) => {
                    const dateA = new Date(a.dataset.date);
                    const dateB = new Date(b.dataset.date);
                    return dateAscending ? dateA - dateB : dateB - dateA;
                });

                dateAscending = !dateAscending;
                
                container.innerHTML = '';
                archiveCards.forEach(card => container.appendChild(card));
            });

            // Delete confirmation
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this archived order? This action cannot be undone.')) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>
</body>
</html> 