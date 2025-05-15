<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reservation Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        }`
        .status-completed {
            background-color: #E0E7FF;
            color: #3730A3;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen overflow-hidden">
       <!-- Sidebar -->
        @include('layouts.app')
            
        <!-- Mobile sidebar toggle -->
        <div class="md:hidden fixed bottom-4 right-4 z-50">
            <button id="sidebar-toggle" class="gradient-bg text-white p-3 rounded-full shadow-lg">
                <i class="fas fa-bars text-xl"></i>
            </button>
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
                            <input type="text" id="searchInput" placeholder="Search by name/email..." class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <select id="statusFilter" class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Reservation Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="reservationTable">
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
                                @foreach($reservations as $reservation)
                                <tr class="hover:bg-gray-50 reservation-row" data-name="{{ strtolower($reservation->name . ' ' . $reservation->email) }}" data-status="{{ $reservation->status }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $reservation->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($reservation->name) }}&background=random" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $reservation->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $reservation->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reservation->reservation_datetime->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reservation->serviceTypeLabel }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $reservation->guest_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 rounded-full text-xs status-{{ $reservation->status }}">{{ ucfirst($reservation->status) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="showDetail({{ $reservation->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="showStatusModal({{ $reservation->id }}, '{{ $reservation->status }}')" class="text-green-600 hover:text-green-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteReservation({{ $reservation->id }})" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Detail Modal -->
    <div id="reservation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="p-6">
                <div class="flex justify-between items-center border-b pb-4">
                    <h3 class="text-xl font-bold">Reservation Details</h3>
                    <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6" id="modal-content">
                    <!-- Content loaded by JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Status Modal -->
    <div id="status-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="p-6">
                <div class="flex justify-between items-center border-b pb-4">
                    <h3 class="text-xl font-bold">Update Status</h3>
                    <button id="close-status-modal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="statusForm" class="mt-6">
                    <input type="hidden" name="reservation_id" id="status-reservation-id">
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status-select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show detail modal
        function showDetail(id) {
            fetch(`/admin/reservations/${id}`)
                .then(res => {
                    if (res.status === 401 || res.status === 403) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unauthorized',
                            text: 'Please login again.'
                        }).then(() => {
                            window.location.href = '/login';
                        });
                        return;
                    }
                    if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    document.getElementById('modal-content').innerHTML = `
                        <div>
                            <h4 class="font-semibold text-gray-700">Customer Information</h4>
                            <div class="mt-4 space-y-3">
                                <p><span class="text-gray-500">Name:</span> <span class="font-medium">${data.name}</span></p>
                                <p><span class="text-gray-500">Email:</span> <span class="font-medium">${data.email}</span></p>
                                <p><span class="text-gray-500">Phone:</span> <span class="font-medium">${data.phone}</span></p>
                                <p><span class="text-gray-500">Special Requests:</span> <span class="font-medium">${data.special_requests || '-'}</span></p>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700">Reservation Details</h4>
                            <div class="mt-4 space-y-3">
                                <p><span class="text-gray-500">Reservation ID:</span> <span class="font-medium">${data.id}</span></p>
                                <p><span class="text-gray-500">Date & Time:</span> <span class="font-medium">${data.reservation_datetime}</span></p>
                                <p><span class="text-gray-500">Service:</span> <span class="font-medium">${data.service_type}</span></p>
                                <p><span class="text-gray-500">Guests:</span> <span class="font-medium">${data.guest_count}</span></p>
                                <p><span class="text-gray-500">Status:</span> <span class="px-2 py-1 rounded-full text-xs status-${data.status}">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span></p>
                                <p><span class="text-gray-500">Admin Notes:</span> <span class="font-medium">${data.admin_notes || '-'}</span></p>
                            </div>
                        </div>
                    `;
                    document.getElementById('reservation-modal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to load reservation details.', 'error');
                });
        }
        document.getElementById('close-modal').onclick = function() {
            document.getElementById('reservation-modal').classList.add('hidden');
        };

        // Show status modal
        function showStatusModal(id, status) {
            document.getElementById('status-reservation-id').value = id;
            document.getElementById('status-select').value = status;
            document.getElementById('admin_notes').value = '';
            document.getElementById('status-modal').classList.remove('hidden');
        }
        document.getElementById('close-status-modal').onclick = function() {
            document.getElementById('status-modal').classList.add('hidden');
        };

        // Handle status update
        document.getElementById('statusForm').onsubmit = function(e) {
            e.preventDefault();
            const id = document.getElementById('status-reservation-id').value;
            const status = document.getElementById('status-select').value;
            const admin_notes = document.getElementById('admin_notes').value;
            fetch(`/admin/reservations/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status, admin_notes })
            })
            .then(res => {
                if (res.status === 401 || res.status === 403) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unauthorized',
                        text: 'Please login again.'
                    }).then(() => {
                        window.location.href = '/login';
                    });
                    return;
                }
                if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        text: data.message || 'Reservation status has been updated.'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to update status.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the status.'
                });
            });
        };

        // Toggle sidebar
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('hidden');
        });

        // Live search & filter
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('.reservation-row');
        function filterRows() {
            const search = searchInput.value.toLowerCase();
            const status = statusFilter.value;
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const rowStatus = row.getAttribute('data-status');
                const matchSearch = name.includes(search);
                const matchStatus = !status || rowStatus === status;
                row.style.display = (matchSearch && matchStatus) ? '' : 'none';
            });
        }
        searchInput.addEventListener('input', filterRows);
        statusFilter.addEventListener('change', filterRows);

        // Perbaikan fungsi deleteReservation (hapus spasi antara funct dan ion)
        function deleteReservation(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This reservation will be deleted permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/reservations/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(res => {
                        if (res.status === 401 || res.status === 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Unauthorized',
                                text: 'Please login again.'
                            }).then(() => {
                                window.location.href = '/login';
                            });
                            return;
                        }
                        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message || 'Reservation has been deleted.', 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Failed to delete reservation.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'An error occurred while deleting the reservation.', 'error');
                    });
                }
            });
        }

        // Tambahkan event listener untuk tombol close modal
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal buttons
            document.getElementById('close-modal').addEventListener('click', function() {
                document.getElementById('reservation-modal').classList.add('hidden');
            });

            document.getElementById('close-status-modal').addEventListener('click', function() {
                document.getElementById('status-modal').classList.add('hidden');
            });

            // Status form submission
            document.getElementById('statusForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('status-reservation-id').value;
                const status = document.getElementById('status-select').value;
                const admin_notes = document.getElementById('admin_notes').value;

                fetch(`/admin/reservations/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status, admin_notes })
                })
                .then(res => {
                    if (res.status === 401 || res.status === 403) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unauthorized',
                            text: 'Please login again.'
                        }).then(() => {
                            window.location.href = '/login';
                        });
                        return;
                    }
                    if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: data.message || 'Reservation status has been updated.'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to update status.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the status.'
                    });
                });
            });
        });
    </script>
</body>
</html>