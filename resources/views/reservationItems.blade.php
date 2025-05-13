<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reservation Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .reservation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        .status-confirmed {
            background-color: #D1FAE5;
            color: #065F46;
        }
        .status-cancelled {
            background-color: #FEE2E2;
            color: #92400E;
        }
        .status-completed {
            background-color: #E0E7FF;
            color: #3730A3;
        }
        .sidebar {
            transition: all 0.3s;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .sidebar.collapsed .logo-text {
            display: none;
        }
        .sidebar.collapsed .logo-icon {
            display: block;
        }
        .logo-icon {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-indigo-800 text-white w-64 flex flex-col">
            <div class="p-4 flex items-center space-x-3">
                <div class="logo-icon">
                    <i class="fas fa-calendar-check text-2xl"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-xl font-bold">ReservEase</h1>
                    <p class="text-xs text-indigo-200">Admin Panel</p>
                </div>
                <button id="toggle-sidebar" class="ml-auto text-indigo-200 hover:text-white">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <nav class="flex-1 mt-6">
                <a href="#" class="flex items-center px-6 py-3 text-white bg-indigo-900">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-indigo-200 hover:text-white hover:bg-indigo-700">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    <span class="sidebar-text">Reservations</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-indigo-200 hover:text-white hover:bg-indigo-700">
                    <i class="fas fa-users mr-3"></i>
                    <span class="sidebar-text">Customers</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-indigo-200 hover:text-white hover:bg-indigo-700">
                    <i class="fas fa-cog mr-3"></i>
                    <span class="sidebar-text">Settings</span>
                </a>
            </nav>
            <div class="p-4 border-t border-indigo-700">
                <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="w-10 h-10 rounded-full">
                    <div class="ml-3 sidebar-text">
                        <p class="text-sm font-medium">Admin User</p>
                        <p class="text-xs text-indigo-200">Super Admin</p>
                    </div>
                    <button class="ml-auto sidebar-text text-indigo-200 hover:text-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="px-6 py-4 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Reservation Management</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button class="p-2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Total Reservations</p>
                            <p class="text-xl font-bold">248</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Confirmed</p>
                            <p class="text-xl font-bold">184</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Pending</p>
                            <p class="text-xl font-bold">42</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Cancelled</p>
                            <p class="text-xl font-bold">22</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="px-6 py-4">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Filters -->
                    <div class="p-4 border-b flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-lg font-semibold">Recent Reservations</h2>
                            <p class="text-sm text-gray-500">Manage all incoming reservations</p>
                        </div>
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <select class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option>All Status</option>
                                <option>Pending</option>
                                <option>Confirmed</option>
                                <option>Cancelled</option>
                                <option>Completed</option>
                            </select>
                            <input type="date" class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </div>
                    </div>

                    <!-- Reservation Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guests</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="reservation-list">
                                <!-- Reservations will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">248</span> results
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-50">
                                Previous
                            </button>
                            <button class="px-3 py-1 border rounded-md bg-indigo-600 text-white">
                                1
                            </button>
                            <button class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-50">
                                2
                            </button>
                            <button class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-50">
                                3
                            </button>
                            <button class="px-3 py-1 border rounded-md text-gray-700 hover:bg-gray-50">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Detail Modal -->
    <div id="reservation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="p-6">
                <div class="flex justify-between items-center border-b pb-4">
                    <h3 class="text-xl font-bold">Reservation Details</h3>
                    <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-700">Customer Information</h4>
                        <div class="mt-4 space-y-3">
                            <p><span class="text-gray-500">Name:</span> <span id="modal-name" class="font-medium">John Doe</span></p>
                            <p><span class="text-gray-500">Email:</span> <span id="modal-email" class="font-medium">john@example.com</span></p>
                            <p><span class="text-gray-500">Phone:</span> <span id="modal-phone" class="font-medium">+1 234 567 890</span></p>
                            <p><span class="text-gray-500">Special Requests:</span> <span id="modal-requests" class="font-medium">Window seat preferred</span></p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700">Reservation Details</h4>
                        <div class="mt-4 space-y-3">
                            <p><span class="text-gray-500">Reservation ID:</span> <span id="modal-id" class="font-medium">RES-2023-001</span></p>
                            <p><span class="text-gray-500">Date & Time:</span> <span id="modal-date" class="font-medium">15 June 2023, 7:30 PM</span></p>
                            <p><span class="text-gray-500">Service:</span> <span id="modal-service" class="font-medium">Dinner Reservation</span></p>
                            <p><span class="text-gray-500">Guests:</span> <span id="modal-guests" class="font-medium">4</span></p>
                            <p><span class="text-gray-500">Status:</span> <span id="modal-status" class="px-2 py-1 rounded-full text-xs status-pending">Pending</span></p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t flex justify-end space-x-3">
                    <button class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        <i class="fas fa-check mr-2"></i>Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample reservation data
        const reservations = [
            {
                id: "RES-2023-001",
                customer: "John Doe",
                email: "john@example.com",
                phone: "+1 234 567 890",
                date: "15 June 2023, 7:30 PM",
                service: "Dinner Reservation",
                guests: 4,
                status: "pending",
                requests: "Window seat preferred"
            },
            {
                id: "RES-2023-002",
                customer: "Jane Smith",
                email: "jane@example.com",
                phone: "+1 987 654 321",
                date: "16 June 2023, 12:30 PM",
                service: "Lunch Reservation",
                guests: 2,
                status: "confirmed",
                requests: "Vegetarian options needed"
            },
            {
                id: "RES-2023-003",
                customer: "Robert Johnson",
                email: "robert@example.com",
                phone: "+1 555 123 4567",
                date: "17 June 2023, 6:00 PM",
                service: "Private Event",
                guests: 10,
                status: "completed",
                requests: "Birthday celebration"
            },
            {
                id: "RES-2023-004",
                customer: "Emily Davis",
                email: "emily@example.com",
                phone: "+1 222 333 4444",
                date: "18 June 2023, 8:00 PM",
                service: "Dinner Reservation",
                guests: 2,
                status: "cancelled",
                requests: "None"
            },
            {
                id: "RES-2023-005",
                customer: "Michael Brown",
                email: "michael@example.com",
                phone: "+1 777 888 9999",
                date: "19 June 2023, 7:00 PM",
                service: "Anniversary Dinner",
                guests: 2,
                status: "pending",
                requests: "Romantic table setup"
            }
        ];

        // Load reservations into table
        function loadReservations() {
            const reservationList = document.getElementById('reservation-list');
            reservationList.innerHTML = '';

            reservations.forEach(reservation => {
                const statusClass = status-${reservation.status};
                const statusText = reservation.status.charAt(0).toUpperCase() + reservation.status.slice(1);

                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${reservation.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=${encodeURIComponent(reservation.customer)}&background=random" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${reservation.customer}</div>
                                <div class="text-sm text-gray-500">${reservation.email}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reservation.date}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reservation.service}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${reservation.guests}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 rounded-full text-xs ${statusClass}">${statusText}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="viewReservation('${reservation.id}')" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="text-red-600 hover:text-red-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                `;
                reservationList.appendChild(row);
            });
        }

        // View reservation details
        function viewReservation(reservationId) {
            const reservation = reservations.find(r => r.id === reservationId);
            if (reservation) {
                document.getElementById('modal-id').textContent = reservation.id;
                document.getElementById('modal-name').textContent = reservation.customer;
                document.getElementById('modal-email').textContent = reservation.email;
                document.getElementById('modal-phone').textContent = reservation.phone;
                document.getElementById('modal-date').textContent = reservation.date;
                document.getElementById('modal-service').textContent = reservation.service;
                document.getElementById('modal-guests').textContent = reservation.guests;
                document.getElementById('modal-requests').textContent = reservation.requests;
                
                const statusElement = document.getElementById('modal-status');
                statusElement.textContent = reservation.status.charAt(0).toUpperCase() + reservation.status.slice(1);
                statusElement.className = px-2 py-1 rounded-full text-xs status-${reservation.status};
                
                document.getElementById('reservation-modal').classList.remove('hidden');
            }
        }

        // Close modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('reservation-modal').classList.add('hidden');
        });

        // Toggle sidebar
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadReservations();
        });
    </script>
</body>
</html>