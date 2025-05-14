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
        .container {
        max-width: 1200px;
    }
    .grid-cols-1.md\:grid-cols-3 {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
    @media (min-width: 768px) {
        .grid-cols-1.md\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    .shadow {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .transition-shadow {
        transition: box-shadow 0.3s;
    }
    table {
        border-collapse: collapse;
    }
    th, td {
        border-bottom: 1px solid #e5e7eb;
    }
    .bg-gray-50 {
        background-color: #f9fafb;
    }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include("layouts.app")

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">User Management</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-600">Total Users</h3>
            <h2 class="text-3xl font-bold mt-2">{{ $totalCustomers }}</h2>
            <p class="text-gray-500 mt-1">{{ $newCustomers }} new this month</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-600">Active Users</h3>
            <h2 class="text-3xl font-bold mt-2">{{ $activeCustomers }}</h2>
            <p class="text-gray-500 mt-1">Based on recent orders</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
            <h3 class="text-lg font-semibold text-gray-600">New Users</h3>
            <h2 class="text-3xl font-bold mt-2">{{ $newCustomers }}</h2>
            <p class="text-gray-500 mt-1">Last 30 days</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4 flex justify-between items-center border-b">
            <h2 class="text-xl font-semibold">All Users</h2>
            <div class="flex space-x-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add User</button>
                <select class="border rounded px-2 py-1">
                    <option>Filter</option>
                </select>
            </div>
        </div>
        <div class="p-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 px-4">User</th>
                        <th class="py-2 px-4">Orders</th>
                        <th class="py-2 px-4">Last Active</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">
                                {{ $customer->customer_name }}
                                @if($customer->order_count > 1)
                                    <span class="text-gray-600 text-sm">(memesan sebanyak {{ $customer->order_count }}x)</span>
                                @elseif($customer->order_count == 1)
                                    <span class="text-gray-600 text-sm">(memesan sebanyak 1x)</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $customer->order_count }}</td>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($customer->last_active)->diffForHumans() }}</td>
                            <td class="py-2 px-4">
                                <div class="flex space-x-2">
                                    -
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>
</body>
</html>