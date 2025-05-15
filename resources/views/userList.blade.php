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
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.1);
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

        th,
        td {
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
        @include('layouts.app')

        <div class="container mx-auto p-6 h-screen overflow-x-scroll">
            <h1 class="text-2xl font-bold mb-6">User Management</h1>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-600">Total Customers (Orders)</h3>
                    <p class="text-2xl font-bold">{{ $totalCustomers }}</p>
                    <p class="text-sm text-gray-500">{{ $newCustomers }} new this month</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-600">Total Added Users</h3>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    <p class="text-sm text-gray-500">{{ $newUsers }} new this month</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-600">Active Users</h3>
                    <p class="text-2xl font-bold">{{ $activeCustomers + $activeUsers }}</p>
                    <p class="text-sm text-gray-500">Last 30 days</p>
                </div>
            </div>

            <!-- Dua Kolom ditumpuk secara vertikal -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Kolom 1: Pengguna yang Memesan -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Customers (From Orders)</h2>
                    </div>

                    <div class="overflow-x-auto max-h-96 overflow-y-auto">
                        <table class="min-w-full bg-white border rounded-lg">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-3 px-4 text-left">Customer Name</th>
                                    <th class="py-3 px-4 text-left">Order Count</th>
                                    <th class="py-3 px-4 text-left">Last Active</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr class="border-b">
                                        <td class="py-3 px-4">{{ $customer->name }}</td>
                                        <td class="py-3 px-4">{{ $customer->order_count }}</td>
                                        <td class="py-3 px-4">
                                            {{ \Carbon\Carbon::parse($customer->last_active)->diffForHumans() }}</td>
                                        <td class="py-3 px-4">
                                            -
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $customers->appends(request()->except('customers_page'))->links() }}
                    </div>
                </div>

                <!-- Kolom 2: Pengguna yang Ditambahkan oleh Admin -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Added Users</h2>
                        <div>
                            <a href="{{ route('admin.users.create') }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add User</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto max-h-96 overflow-y-auto">
                        @if (session('success'))
                            <div id="successNotification"
                                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 transition-opacity duration-500">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div id="errorNotification"
                                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 transition-opacity duration-500">
                                {{ session('error') }}
                            </div>
                        @endif
                        <!-- Tabel Pengguna -->
                        <table class="min-w-full bg-white shadow rounded-lg">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                                    <th class="py-3 px-4 text-left">User</th>
                                    <th class="py-3 px-4 text-left">Email</th>
                                    <th class="py-3 px-4 text-left">Role</th>
                                    <th class="py-3 px-4 text-left">Last Active</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @foreach ($users as $user)
                                    <tr class="border-b">
                                        <td class="py-3 px-4">{{ $user->name }}</td>
                                        <td class="py-3 px-4">{{ $user->email }}</td>
                                        <td class="py-3 px-4">{{ ucfirst($user->role) }}</td>
                                        <td class="py-3 px-4">
                                            {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                                        <td class="py-3 px-4">
                                            <button type="button" class="text-red-500 hover:underline open-modal"
                                                data-user-id="{{ $user->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $users->appends(request()->except('users_page'))->links() }}
                        </div>

                        <!-- Modal untuk Konfirmasi Penghapusan -->
                        <div id="deleteModal"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                                <h2 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h2>
                                <p class="mb-6">Apakah Anda yakin ingin menghapus pengguna ini?</p>
                                <div class="flex justify-end space-x-3">
                                    <button id="cancelDelete"
                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Batal</button>
                                    <form id="deleteForm" method="POST" action="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <script>
                            const modal = document.getElementById('deleteModal');
                            const openModalButtons = document.querySelectorAll('.open-modal');
                            const cancelButton = document.getElementById('cancelDelete');
                            const deleteForm = document.getElementById('deleteForm');

                            openModalButtons.forEach(button => {
                                button.addEventListener('click', function() {
                                    const userId = this.getAttribute('data-user-id');
                                    deleteForm.action = "{{ route('admin.users.delete', ':id') }}".replace(':id', userId);
                                    modal.classList.remove('hidden');
                                });
                            });

                            cancelButton.addEventListener('click', function() {
                                modal.classList.add('hidden');
                            });

                            modal.addEventListener('click', function(e) {
                                if (e.target === modal) {
                                    modal.classList.add('hidden');
                                }
                            });
                            // Fungsi untuk menghapus notifikasi setelah 2 detik
                            document.addEventListener('DOMContentLoaded', function() {
                                const successNotification = document.getElementById('successNotification');
                                const errorNotification = document.getElementById('errorNotification');

                                if (successNotification) {
                                    setTimeout(() => {
                                        successNotification.remove();
                                    }, 2000); // 2000 ms = 2 detik
                                }

                                if (errorNotification) {
                                    setTimeout(() => {
                                        errorNotification.remove();
                                    }, 2000); // 2000 ms = 2 detik
                                }
                            });
                        </script>
</body>

</html>
