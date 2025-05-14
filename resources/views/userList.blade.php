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
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include("layouts.app")

        <div class="container">
            <div class="header">
                <h1>User Management</h1>
            </div>
        
            <div class="stats">
                <div class="card">
                    <h3>Total Users</h3>
                    <h2>{{ $totalCustomers }}</h2>
                    <p>{{ $newCustomers }} new this month</p>
                </div>
                <div class="card">
                    <h3>Active Users</h3>
                    <h2>{{ $activeCustomers }}</h2>
                    <p>Based on recent orders</p>
                </div>
                <div class="card">
                    <h3>New Users</h3>
                    <h2>{{ $newCustomers }}</h2>
                    <p>Last 30 days</p>
                </div>
            </div>
        
            <div class="table-section">
                <div class="table-header">
                    <h2>All Users</h2>
                    <div class="table-actions">
                        <button>Add User</button>
                        <select>
                            <option>Filter</option>
                        </select>
                    </div>
                </div>
        
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Orders</th>
                            <th>Last Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>
                                    {{ $customer->customer_name }}
                                    @if($customer->order_count > 1)
                                        <span>(memesan sebanyak {{ $customer->order_count }}x)</span>
                                    @elseif($customer->order_count == 1)
                                        <span>(memesan sebanyak 1x)</span>
                                    @endif
                                </td>
                                <td>{{ $customer->order_count }}</td>
                                <td>{{ \Carbon\Carbon::parse($customer->last_active)->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('customers.orders', $customer->customer_name) }}">
                                        <button>View</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        
                <div class="pagination">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
</body>
</html>