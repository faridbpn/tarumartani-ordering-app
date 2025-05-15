<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - User Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        dark: '#1F2937',
                        light: '#F9FAFB',
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .nav-text {
            display: none;
        }
        .sidebar.collapsed .logo-text {
            display: none;
        }
        .sidebar.collapsed .nav-item {
            justify-content: center;
        }
        .content {
            transition: all 0.3s ease;
        }
        .content.expanded {
            margin-left: 80px;
        }
        .user-avatar {
            transition: all 0.3s ease;
        }
        .user-avatar:hover {
            transform: scale(1.1);
        }
        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .pagination-btn:hover {
            background-color: #E5E7EB;
        }
        .active-pagination {
            background-color: #4F46E5;
            color: white;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            z-index: 1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        tr:hover {
            background-color: #F9FAFB;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.app')
        
        <!-- Main Content -->
        <div class="content flex-1 overflow-y-auto">
            <!-- Top Navigation -->
            <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="text-gray-500 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-dark">User Management</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    
                    <div class="relative">
                        <button class="text-gray-500 focus:outline-none relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                    
                    <div class="dropdown relative">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center">
                                <span>{{ Auth::user()->name[0] ?? 'A' }}</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                        </button>
                        <div class="dropdown-content mt-2 bg-white rounded-md shadow-lg py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Users</p>
                                <h3 class="text-2xl font-bold text-dark">{{ $totalCustomers ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <p class="text-xs text-green-500 mt-2"><i class="fas fa-arrow-up mr-1"></i> {{ $newCustomers ? round(($newCustomers / ($totalCustomers ?: 1)) * 100, 1) : 0 }}% from last month</p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Active Users</p>
                                <h3 class="text-2xl font-bold text-dark">{{ $activeCustomers ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <p class="text-xs text-green-500 mt-2"><i class="fas fa-arrow-up mr-1"></i> {{ $activeCustomers ? round(($activeCustomers / ($totalCustomers ?: 1)) * 100, 1) : 0 }}% from last month</p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Admin Users</p>
                                <h3 class="text-2xl font-bold text-dark">{{ $adminUsers ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Based on role assignments</p>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">New Users</p>
                                <h3 class="text-2xl font-bold text-dark">{{ $newCustomers ?? 0 }}</h3>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <p class="text-xs text-green-500 mt-2"><i class="fas fa-arrow-up mr-1"></i> {{ $newCustomers ? round(($newCustomers / ($totalCustomers ?: 1)) * 100, 1) : 0 }}% from last month</p>
                    </div>
                </div>
                
                <!-- User Table Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-dark">All Users</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                <i class="fas fa-plus mr-2"></i> Add User
                            </a>
                            <div class="relative">
                                <button id="filterToggle" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                    <i class="fas fa-filter mr-2"></i> Filter
                                </button>
                                <div id="filterDropdown" class="hidden absolute right-0 mt-2 bg-white rounded-md shadow-lg py-1 z-10">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Active Users</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Inactive Users</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admins</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Customers</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <input type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" id="selectAll">
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Active</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <input type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded user-checkbox" data-id="{{ $customer->id }}">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                                                        <span class="text-primary">{{ $customer->customer_name[0] }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $customer->customer_name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $customer->email ?? 'No email' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $customer->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $customer->role == 'admin' ? 'Admin' : 'Customer' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $customer->status == 'active' ? 'bg-green-100 text-green-800' : 
                                                   ($customer->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($customer->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $customer->order_count }}
                                            @if($customer->order_count > 1)
                                                <span>(memesan sebanyak {{ $customer->order_count }}x)</span>
                                            @elseif($customer->order_count == 1)
                                                <span>(memesan sebanyak 1x)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($customer->last_active)->sdiffForHumans() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('customers.orders', $customer->customer_name) }}" class="text-blue-600 hover:text-blue-900">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('customers.edit', $customer->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-medium">{{ $customers->firstItem() }}</span> to <span class="font-medium">{{ $customers->lastItem() }}</span> of <span class="font-medium">{{ $customers->total() }}</span> results
                        </div>
                        <div class="flex space-x-1">
                            {{ $customers->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.content').classList.toggle('expanded');
        });

        // Toggle filter dropdown
        document.getElementById('filterToggle').addEventListener('click', function() {
            document.getElementById('filterDropdown').classList.toggle('hidden');
        });

        // Select all checkboxes
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Update select all checkbox based on individual checkboxes
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(document.querySelectorAll('.user-checkbox')).every(cb => cb.checked);
                document.getElementById('selectAll').checked = allChecked;
            });
        });
    </script>
</body>
</html>