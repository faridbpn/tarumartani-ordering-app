<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - FoodExpress Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('images/overview/logotarumartani.webp') }}" type="image/svg+xml">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); }
        .sidebar { 
            transition: all 0.3s ease;
            z-index: 50;
        }
        .sidebar.active {
            transform: translateX(0);
        }
        .order-card { transition: all 0.2s ease; cursor: pointer; }
        .order-card:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); }
        .status-badge { font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 9999px; }
        .order-item { border-bottom: 1px dashed #e5e7eb; padding: 0.5rem 0; }
        .order-item:last-child { border-bottom: none; }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                bottom: 0;
                width: 80%;
                max-width: 300px;
            }
            
            .sidebar.active {
                left: 0;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Kustomisasi SweetAlert2 */
    .swal2-popup {
        border-radius: 10px !important;
        padding: 20px !important;
    }
    .swal2-title {
        font-size: 24px !important;
        font-weight: bold !important;
        color: #000 !important;
    }
    .swal2-content {
        font-size: 16px !important;
        color: #666 !important;
    }
    .swal2-confirm {
        border-radius: 5px !important;
        padding: 10px 20px !important;
    }
    .swal2-cancel {
        border-radius: 5px !important;
        padding: 10px 20px !important;
    }

    /* Modal Animation */
#deleteConfirmationModal .transform {
    transition: transform 0.3s ease;
}

#deleteConfirmationModal.active {
    display: flex;
}

#deleteConfirmationModal.active .transform {
    transform: scale(1);
}

/* Modal Styling */
#deleteConfirmationModal .bg-white {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

/* Icon Animation */
#deleteConfirmationModal .bg-red-100 {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

/* Button Hover Effects */
#deleteConfirmationModal button {
    transition: background-color 0.3s ease;
}
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
@include('layouts.app')
    
    <!-- Mobile sidebar toggle -->
    <div class="md:hidden fixed bottom-4 right-4 z-50">
        <button id="sidebar-toggle" class="gradient-bg text-white p-3 rounded-full shadow-lg">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="bg-white shadow-sm p-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">   
                <h2 class="text-xl font-bold text-gray-800">Orders Management</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-xl text-gray-500"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                </div>
                <div class="hidden md:flex items-center space-x-2">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="w-8 h-8 rounded-full">
                    <span class="font-medium">Admin</span>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-[#f6f8fb]">
            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow p-4 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-72">
                        <input type="text" id="searchInput" placeholder="Search orders..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-[#f6f8fb]">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select id="statusFilter" class="border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-[#f6f8fb]">
                        <option value="All">All Status</option>
                        <option value="Completed">Completed</option>
                        <option value="Processing">Processing</option>
                        <option value="On Delivery">On Delivery</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>

            <!-- Order List -->
            @if ($orders->isEmpty())
                <div class="bg-white rounded-2xl shadow p-8 text-center">
                    <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-800">No Orders Found</h3>
                    <p class="text-gray-500">There are currently no orders to display.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($orders as $order)

                    <div class="order-card bg-white rounded-2xl shadow-md border border-gray-100 p-6" 
                         data-status="{{ $order->status }}" 
                         data-search="{{ $order->customer_name }} {{ $order->id }} @foreach($order->items as $item) {{ $item->menuItem->name }} @endforeach">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                                <p class="text-sm text-gray-500">
                                    @if(now()->diffInMinutes($order->created_at) < 60)
                                        {{ now()->diffInMinutes($order->created_at) }} min ago
                                    @elseif(now()->diffInHours($order->created_at) < 24)
                                        {{ now()->diffInHours($order->created_at) }} hour{{ now()->diffInHours($order->created_at) > 1 ? 's' : '' }} ago
                                    @else
                                        {{ now()->diffInDays($order->created_at) }} day{{ now()->diffInDays($order->created_at) > 1 ? 's' : '' }} ago
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Status update form -->
                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" 
                                        class="status-badge px-3 py-1 rounded-lg text-sm font-medium
                                        @if($order->status == 'Completed') bg-green-100 text-green-700
                                        @elseif($order->status == 'Processing') bg-yellow-100 text-yellow-700
                                        @elseif($order->status == 'On Delivery') bg-blue-100 text-blue-700
                                        @elseif($order->status == 'Cancelled') bg-red-100 text-red-700
                                        @else bg-purple-100 text-purple-700 @endif">
                                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="On Delivery" {{ $order->status == 'On Delivery' ? 'selected' : '' }}>On Delivery</option>
                                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>

                                <!-- Archive button form -->
                                <form action="{{ route('orders.archive', $order->id) }}" method="POST" class="archive-form ml-2">
                                    @csrf
                                    <input type="hidden" name="archive_reason" value="Selesai disajikan">
                                    <button type="button" class="btn-archive bg-yellow-500 text-white px-2 py-1 rounded">Arsipkan</button>
                                </form>

                   
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-medium text-gray-800">{{ $order->customer_name }}</h4>
                            <p class="text-sm text-gray-500">
                                Table #{{ $order->table_number }} - {{ $order->items->sum('quantity') }} items - ${{ number_format($order->total_amount, 2) }}
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
                    @endforeach
                </div>
            @endif
        </main>
    </div>

    <!-- Modal for Delete Confirmation -->
<div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 text-center transform scale-95 transition-transform duration-300">
        <div class="flex justify-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Apakah Anda yakin ingin menghapus order ini?</h3>
        <p class="text-sm text-gray-600 mb-4" id="deleteOrderId"></p>
        <div class="flex justify-center space-x-3">
            <button id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Hapus</button>
            <button onclick="closeDeleteConfirmation()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
         document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('inset-0');
                sidebar.classList.toggle('z-40');
            });
            
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => {
                        btn.classList.remove('tab-active');
                        btn.classList.add('text-gray-500');
                    });
                    this.classList.add('tab-active');
                    this.classList.remove('text-gray-500');
                    
                    const tab = this.getAttribute('data-tab');
                    const orders = document.querySelectorAll('.order-card');
                    
                    orders.forEach(order => {
                        if (tab === 'all' || order.dataset.status === tab) {
                            order.style.display = 'block';
                        } else {
                            order.style.display = 'none';
                        }
                    });
                });
            });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const orderCards = document.querySelectorAll('.order-card');
            
            orderCards.forEach(card => {
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
            const status = this.value;
            const orderCards = document.querySelectorAll('.order-card');
            
            orderCards.forEach(card => {
                const cardStatus = card.dataset.status;
                if (status === 'All' || cardStatus === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Archive confirmation dengan SweetAlert2
        document.querySelectorAll('.btn-archive').forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({ 
                    title: 'Konfirmasi',
                    text: 'Yakin ingin mengarsipkan pesanan ini ke riwayat arsip?',
                    icon: 'question', // Ikon tanda tanya untuk konfirmasi
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#6f42c1', // Warna ungu seperti SweetAlert2
                    cancelButtonColor: '#d3d3d3', // Warna abu-abu untuk tombol Cancel
                    background: '#fff', // Latar belakang putih
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form untuk mengarsipkan pesanan
                        this.closest('form').submit();
                        // Tampilkan notifikasi sukses setelah arsip
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pesanan telah diarsipkan.',
                            icon: 'success', // Ikon centang hijau
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#6f42c1'
                        });
                    }
                });
            });
        });
    });
</script>

</body>
</html>