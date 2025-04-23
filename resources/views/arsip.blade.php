<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive - FoodExpress Admin</title>
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
        }
        
        .active-nav {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }
        
        .archive-card {
            transition: all 0.2s ease;
        }
        
        .archive-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
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
                <button class="md:hidden text-gray-500">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-gray-800">Archive Management</h2>
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
            <!-- Filters and Actions -->
            <div class="bg-white rounded-xl shadow p-4 mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="relative w-full md:w-64">
                    <input type="text" placeholder="Search archive..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <select class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Types</option>
                        <option>Menu Items</option>
                        <option>Orders</option>
                        <option>Customers</option>
                    </select>
                    <select class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Status</option>
                        <option>Archived</option>
                        <option>Deleted</option>
                    </select>
                    <button class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg transition-all">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </div>
            </div>
            
            <!-- Archive Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Archive Item 1 -->
                <div class="archive-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="status-badge bg-blue-100 text-blue-800">Archived</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i> 15 Jun 2023
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start mb-3">
                            <div class="bg-gray-100 p-3 rounded-lg mr-3">
                                <i class="fas fa-utensils text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Nasi Goreng Special</h3>
                                <p class="text-sm text-gray-500">Menu Item</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Premium version of our traditional nasi goreng with additional seafood and special sauce.</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Archived by: <span class="font-medium">Admin</span></span>
                            <div class="flex space-x-2">
                                <button class="restore-btn p-2 text-green-500 hover:bg-green-50 rounded-lg" data-id="1">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button class="delete-permanent-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Archive Item 2 -->
                <div class="archive-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="status-badge bg-red-100 text-red-800">Deleted</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i> 22 May 2023
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start mb-3">
                            <div class="bg-gray-100 p-3 rounded-lg mr-3">
                                <i class="fas fa-shopping-cart text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Order #45892</h3>
                                <p class="text-sm text-gray-500">Order</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Order from customer John Doe with total $45.20. Canceled by customer.</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Deleted by: <span class="font-medium">System</span></span>
                            <div class="flex space-x-2">
                                <button class="restore-btn p-2 text-green-500 hover:bg-green-50 rounded-lg" data-id="2">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button class="delete-permanent-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Archive Item 3 -->
                <div class="archive-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="status-badge bg-blue-100 text-blue-800">Archived</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i> 10 May 2023
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start mb-3">
                            <div class="bg-gray-100 p-3 rounded-lg mr-3">
                                <i class="fas fa-users text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Sarah Johnson</h3>
                                <p class="text-sm text-gray-500">Customer</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Inactive customer for more than 2 years. Last order on 12 Apr 2021.</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Archived by: <span class="font-medium">Admin</span></span>
                            <div class="flex space-x-2">
                                <button class="restore-btn p-2 text-green-500 hover:bg-green-50 rounded-lg" data-id="3">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button class="delete-permanent-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="3">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Archive Item 4 -->
                <div class="archive-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="status-badge bg-blue-100 text-blue-800">Archived</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i> 5 May 2023
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start mb-3">
                            <div class="bg-gray-100 p-3 rounded-lg mr-3">
                                <i class="fas fa-utensils text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Es Campur</h3>
                                <p class="text-sm text-gray-500">Menu Item</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Seasonal dessert item. Archived for next season availability.</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Archived by: <span class="font-medium">Manager</span></span>
                            <div class="flex space-x-2">
                                <button class="restore-btn p-2 text-green-500 hover:bg-green-50 rounded-lg" data-id="4">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button class="delete-permanent-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="4">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Archive Item 5 -->
                <div class="archive-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="status-badge bg-red-100 text-red-800">Deleted</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i> 28 Apr 2023
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start mb-3">
                            <div class="bg-gray-100 p-3 rounded-lg mr-3">
                                <i class="fas fa-shopping-cart text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Order #45721</h3>
                                <p class="text-sm text-gray-500">Order</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Failed payment order. System automatically deleted after 30 days.</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Deleted by: <span class="font-medium">System</span></span>
                            <div class="flex space-x-2">
                                <button class="restore-btn p-2 text-green-500 hover:bg-green-50 rounded-lg" data-id="5">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button class="delete-permanent-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="5">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Archive Item 6 -->
                <div class="archive-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="status-badge bg-blue-100 text-blue-800">Archived</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-1"></i> 15 Apr 2023
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-start mb-3">
                            <div class="bg-gray-100 p-3 rounded-lg mr-3">
                                <i class="fas fa-utensils text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="font-bold">Soto Betawi</h3>
                                <p class="text-sm text-gray-500">Menu Item</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Temporarily unavailable due to ingredient supply issues.</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Archived by: <span class="font-medium">Chef</span></span>
                            <div class="flex space-x-2">
                                <button class="restore-btn p-2 text-green-500 hover:bg-green-50 rounded-lg" data-id="6">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button class="delete-permanent-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="6">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                <nav class="inline-flex rounded-md shadow">
                    <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-blue-600 font-medium">1</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">2</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">3</a>
                    <a href="#" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </main>
    </div>

    <!-- Restore Confirmation Modal -->
    <div id="restore-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-xl shadow-lg w-full max-w-md overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold">Confirm Restoration</h3>
                <button id="close-restore-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
  </div>

            <div class="p-4">
                <p class="mb-4">Are you sure you want to restore this item? It will be moved back to its original location.</p>
                <input type="hidden" id="restore-item-id">
                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-restore-btn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="button" id="confirm-restore-btn" class="px-4 py-2 gradient-bg text-white rounded-lg hover:opacity-90">Restore</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Permanent Delete Confirmation Modal -->
    <div id="delete-permanent-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-xl shadow-lg w-full max-w-md overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold">Confirm Permanent Deletion</h3>
                <button id="close-delete-permanent-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-4">
                <p class="mb-4">Are you sure you want to permanently delete this item? This action cannot be undone and all data will be lost.</p>
                <input type="hidden" id="delete-permanent-item-id">
                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-delete-permanent-btn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="button" id="confirm-delete-permanent-btn" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete Permanently</button>
                </div>
            </div>
        </div>
    </div>

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
            
            // Modal elements
            const restoreModal = document.getElementById('restore-modal');
            const deletePermanentModal = document.getElementById('delete-permanent-modal');
            const restoreBtns = document.querySelectorAll('.restore-btn');
            const deletePermanentBtns = document.querySelectorAll('.delete-permanent-btn');
            const closeRestoreModalBtns = [document.getElementById('close-restore-modal'), document.getElementById('cancel-restore-btn')];
            const closeDeletePermanentModalBtns = [document.getElementById('close-delete-permanent-modal'), document.getElementById('cancel-delete-permanent-btn')];
            const confirmRestoreBtn = document.getElementById('confirm-restore-btn');
            const confirmDeletePermanentBtn = document.getElementById('confirm-delete-permanent-btn');
            
            // Sample data for demonstration
            let archiveItems = [
                { id: 1, type: 'menu', name: 'Nasi Goreng Special', status: 'archived', date: '15 Jun 2023', description: 'Premium version of our traditional nasi goreng with additional seafood and special sauce.', archivedBy: 'Admin' },
                { id: 2, type: 'order', name: 'Order #45892', status: 'deleted', date: '22 May 2023', description: 'Order from customer John Doe with total $45.20. Canceled by customer.', archivedBy: 'System' },
                { id: 3, type: 'customer', name: 'Sarah Johnson', status: 'archived', date: '10 May 2023', description: 'Inactive customer for more than 2 years. Last order on 12 Apr 2021.', archivedBy: 'Admin' },
                { id: 4, type: 'menu', name: 'Es Campur', status: 'archived', date: '5 May 2023', description: 'Seasonal dessert item. Archived for next season availability.', archivedBy: 'Manager' },
                { id: 5, type: 'order', name: 'Order #45721', status: 'deleted', date: '28 Apr 2023', description: 'Failed payment order. System automatically deleted after 30 days.', archivedBy: 'System' },
                { id: 6, type: 'menu', name: 'Soto Betawi', status: 'archived', date: '15 Apr 2023', description: 'Temporarily unavailable due to ingredient supply issues.', archivedBy: 'Chef' }
            ];
            
            // Toggle modal function
            function toggleModal(modal, show) {
                if (show) {
                    modal.classList.remove('opacity-0', 'invisible');
                    modal.classList.add('active');
                } else {
                    modal.classList.remove('active');
                    setTimeout(() => {
                        modal.classList.add('opacity-0', 'invisible');
                    }, 300);
                }
            }
            
            // Restore item
            restoreBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = parseInt(this.getAttribute('data-id'));
                    document.getElementById('restore-item-id').value = itemId;
                    toggleModal(restoreModal, true);
                });
            });
            
            // Delete permanent
            deletePermanentBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = parseInt(this.getAttribute('data-id'));
                    document.getElementById('delete-permanent-item-id').value = itemId;
                    toggleModal(deletePermanentModal, true);
                });
            });
            
            // Close modals
            closeRestoreModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    toggleModal(restoreModal, false);
                });
            });
            
            closeDeletePermanentModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    toggleModal(deletePermanentModal, false);
                });
            });
            
            // Confirm restore
            confirmRestoreBtn.addEventListener('click', function() {
                const itemId = parseInt(document.getElementById('restore-item-id').value);
                
                // In a real app, you would send restore request to server here
                alert('Item restored successfully!');
                toggleModal(restoreModal, false);
                
                // Remove from archive list (in a real app, you would refresh the list)
                archiveItems = archiveItems.filter(item => item.id !== itemId);
            });
            
            // Confirm permanent delete
            confirmDeletePermanentBtn.addEventListener('click', function() {
                const itemId = parseInt(document.getElementById('delete-permanent-item-id').value);
                
                // In a real app, you would send delete request to server here
                alert('Item permanently deleted!');
                toggleModal(deletePermanentModal, false);
                
                // Remove from archive list (in a real app, you would refresh the list)
                archiveItems = archiveItems.filter(item => item.id !== itemId);
            });
    });
  </script>
</body>
</html>