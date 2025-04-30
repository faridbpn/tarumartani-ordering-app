<!DOCTYPE html>
<html lang="en">
<head>
    @vite([])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FoodExpress</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        }
        
        .sidebar {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        
        .active-nav {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        .order-row:hover {
            background-color: #f1f5f9;
        }

        .modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .modal-content {
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal.active .modal-content {
            transform: translateY(0);
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include("layouts.app")
    
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
                <button class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
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
        <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Total Orders -->
                <div class="bg-white rounded-xl shadow p-6 card-hover transition-all" onclick="showOrderHistoryModal()">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Total Orders (This Month)</p>
                            <h3 class="text-2xl font-bold">{{ $totalOrders }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Monthly Favorite Menu -->
                <div class="bg-white rounded-xl shadow p-6 card-hover transition-all" onclick="showFavoriteMenuHistoryModal()">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Monthly Favorite Menu</p>
                            <h3 class="text-2xl font-bold">{{ $favoriteMenu ? $favoriteMenu->name : 'N/A' }}</h3>
                            <p class="text-sm text-green-500 mt-1">
                                Ordered {{ $favoriteMenuCount }} times
                            </p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-star text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Items -->
                <div class="bg-white rounded-xl shadow p-6 card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Menu Items</p>
                            <h3 class="text-2xl font-bold">{{ $totalMenuItems }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-utensils text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Total Orders Chart -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Total Orders</h3>
                        <form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}">
                            <select name="filter" onchange="this.form.submit()" class="bg-gray-100 border-0 rounded-lg px-3 py-1 text-sm">
                                <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Today</option>
                                <option value="last30days" {{ $filter == 'last30days' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="last90days" {{ $filter == 'last90days' ? 'selected' : '' }}>Last 90 Days</option>
                            </select>
                        </form>
                    </div>
                    <div class="chart-container">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
                
                <!-- Top 3 Favorite Menus Chart -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Top 3 Favorite Menus (All Time)</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="topMenusChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Order History Modal -->
            <div id="orderHistoryModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal-content">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-lg font-semibold">Order History (Per Month)</h3>
                        <button onclick="closeOrderHistoryModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-4 max-h-96 overflow-y-auto">
                        @foreach ($orderHistory as $history)
                            <div class="flex justify-between py-2 border-b">
                                <span>{{ $history['month'] }}</span>
                                <span class="font-medium">{{ $history['total'] }} orders</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Favorite Menu History Modal -->
            <div id="favoriteMenuHistoryModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal-content">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-lg font-semibold">Favorite Menu History (Per Month)</h3>
                        <button onclick="closeFavoriteMenuHistoryModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-4 max-h-96 overflow-y-auto">
                        @foreach ($favoriteMenuHistory as $history)
                            <div class="py-2 border-b">
                                <div class="flex justify-between">
                                    <span>{{ $history['month'] }}</span>
                                    <span class="font-medium">{{ $history['menu_name'] }}</span>
                                </div>
                                <p class="text-sm text-gray-500">Ordered {{ $history['order_count'] }} times</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Orders (Biarkan seperti adanya) -->
            <div class="bg-white rounded-xl shadow overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-lg">Recent Orders</h3>
                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View All
                        </button>
                    </div>
                </div>
                <!-- ... (Bagian ini tetap menggunakan data dummy, Anda bisa mengupdate sesuai kebutuhan) -->
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            
            // Orders Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            const ordersChart = new Chart(ordersCtx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Total Orders',
                        data: @json($data),
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Top 3 Favorite Menus Chart
            const topMenusCtx = document.getElementById('topMenusChart').getContext('2d');
            const topMenusChart = new Chart(topMenusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($pieLabels),
                    datasets: [{
                        data: @json($pieData),
                        backgroundColor: [
                            '#3b82f6',
                            '#6366f1',
                            '#8b5cf6'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '70%'
                }
            });
        });

        // Functions to handle modals
        function showOrderHistoryModal() {
            document.getElementById('orderHistoryModal').classList.remove('hidden');
            document.getElementById('orderHistoryModal').classList.add('active');
        }

        function closeOrderHistoryModal() {
            document.getElementById('orderHistoryModal').classList.remove('active');
            document.getElementById('orderHistoryModal').classList.add('hidden');
        }

        function showFavoriteMenuHistoryModal() {
            document.getElementById('favoriteMenuHistoryModal').classList.remove('hidden');
            document.getElementById('favoriteMenuHistoryModal').classList.add('active');
        }

        function closeFavoriteMenuHistoryModal() {
            document.getElementById('favoriteMenuHistoryModal').classList.remove('active');
            document.getElementById('favoriteMenuHistoryModal').classList.add('hidden');
        }
    </script>
</body>
</html>