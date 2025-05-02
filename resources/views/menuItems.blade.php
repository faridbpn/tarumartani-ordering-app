<!DOCTYPE html>
<html lang="en">
<head>
    @vite([])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - FoodExpress Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .menu-card {
            transition: all 0.2s ease;
        }
        
        .menu-card:hover {
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
        
        .category-tab.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .image-upload-preview {
            background-size: cover;
            background-position: center;
        }

        .toast {
            transition: opacity 0.3s ease;
        }

        .hidden {
            display: none;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 4px;
            background-color: white;
            color: #3b82f6;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination li.active span {
            background-color: #3b82f6;
            color: white;
        }

        .pagination li a:hover {
            background-color: #f3f4f6;
        }

        .pagination li.disabled span {
            color: #9ca3af;
            cursor: not-allowed;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in {
            animation: fade-in 0.2s ease-out;
        }

    </style>
</head>
<body class="flex h-screen">
    <!-- Navbar -->
    @include('layouts.app')
    
    <!-- Mobile sidebar toggle -->
    <div class="md:hidden fixed bottom-4 right-4 z-50">
        <button id="sidebar-toggle" class="gradient-bg text-white p-3 rounded-full shadow-lg">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    
    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg hidden">
        <span id="toastMessage"></span>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Menu Management</h1>
            <button data-action="add-menu" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all">
                <i class="fas fa-plus mr-2"></i> Add Menu
            </button>
        </div>
        
        <!-- Search and Filters -->
        <div class="bg-white rounded-xl shadow p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <input type="text" id="searchInput" placeholder="Search menu items..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex gap-2">
                    <select id="categoryFilter" class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select id="statusFilter" class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($menus as $menu)
            <div class="menu-card bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition-shadow">
                <div class="relative">
                    <img src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://via.placeholder.com/300x200' }}" 
                         alt="{{ $menu->name }}" 
                         class="w-full h-36 object-cover">
                    <div class="absolute top-2 right-2 flex space-x-2">
                        <button data-action="edit-menu" data-id="{{ $menu->id }}" 
                                class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full transition-colors">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button data-action="delete-menu" data-id="{{ $menu->id }}" 
                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $menu->name }}</h3>
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">{{ $menu->description }}</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $menu->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $menu->is_available ? 'Available' : 'Not Available' }}
                            </span>
                            <span class="text-xs text-gray-500" data-category-id="{{ $menu->category_id ?? '' }}">
                                {{ isset($menu->category->name) ? $menu->category->name : 'No Category' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $menus->links() }}
        </div>
    </div>
    
    <!-- Add/Edit Modal -->
    <div id="menuModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md modal-content animate-fade-in">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-800" id="modalTitle">👨‍🍳Add New Menu</h3>
                <button data-action="close-modal" class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="menuForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                <input type="hidden" id="menuId" name="id">
    
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
    
                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Description</label>
                    <textarea name="description" id="description"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none h-24"></textarea>
                </div>
    
                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Price (Rp)</label>
                    <input type="number" name="price" id="price" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
    
                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Category</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Availability -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Availability</label>
                    <select name="is_available" id="is_available" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>
    
                <!-- Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-100 file:text-blue-800 hover:file:bg-blue-200 transition">
                    <img id="imagePreview" class="mt-3 w-full h-36 object-cover rounded-lg shadow hidden" alt="Image Preview">
                </div>
    
                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" data-action="close-modal"
                        class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal-content">
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-4">Confirm Delete</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this menu item? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button data-action="close-delete-modal"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button data-action="confirm-delete"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>

// Mobile sidebar toggle
const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('fixed');
                sidebar.classList.toggle('inset-0');
                sidebar.classList.toggle('z-40');
            });


        document.addEventListener('DOMContentLoaded', function() {
            const menuModal = document.getElementById('menuModal');
            const deleteModal = document.getElementById('deleteModal');
            const menuForm = document.getElementById('menuForm');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const imagePreview = document.getElementById('imagePreview');
            const imageInput = document.getElementById('image');
            
            // Show toast notification
            function showToast(message, type = 'success') {
                toastMessage.textContent = message;
                toast.classList.remove('hidden');
                toast.classList.remove('bg-red-500', 'bg-green-500');
                toast.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
                setTimeout(() => toast.classList.add('hidden'), 3000);
            }
            
            // Handle image preview
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            // Add Menu Button
            document.querySelector('[data-action="add-menu"]').addEventListener('click', function() {
                document.getElementById('modalTitle').textContent = 'Add New Menu';
                document.getElementById('menuId').value = '';
                menuForm.reset();
                imagePreview.classList.add('hidden');
                menuModal.classList.remove('hidden');
            });
            
            // Edit Menu Button
            document.querySelectorAll('[data-action="edit-menu"]').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.dataset.id;
                    fetch(`/admin/menu/${menuId}`)
                        .then(response => response.json())
                        .then(menu => {
                            document.getElementById('modalTitle').textContent = 'Edit Menu';
                            document.getElementById('menuId').value = menu.id;
                            document.getElementById('name').value = menu.name;
                            document.getElementById('description').value = menu.description;
                            document.getElementById('price').value = menu.price;
                            document.getElementById('category_id').value = menu.category_id;
                            document.getElementById('is_available').value = menu.is_available ? '1' : '0';
                            
                            if (menu.image) {
                                imagePreview.src = `/storage/${menu.image}`;
                                imagePreview.classList.remove('hidden');
                            } else {
                                imagePreview.classList.add('hidden');
                            }
                            
                            menuModal.classList.remove('hidden');
                        });
                });
            });
            
            // Delete Menu Button
            document.querySelectorAll('[data-action="delete-menu"]').forEach(button => {
                button.addEventListener('click', function() {
                    const menuId = this.dataset.id;
                    deleteModal.classList.remove('hidden');
                    deleteModal.dataset.menuId = menuId;
                });
            });
            
            // Close Modal Buttons
            document.querySelectorAll('[data-action="close-modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    menuModal.classList.add('hidden');
                });
            });
            
            document.querySelectorAll('[data-action="close-delete-modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    deleteModal.classList.add('hidden');
                });
            });
            
            // Confirm Delete Button
            document.querySelector('[data-action="confirm-delete"]').addEventListener('click', function() {
                const menuId = deleteModal.dataset.menuId;
                fetch(`/admin/menu/${menuId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Menu deleted successfully');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    showToast('Error deleting menu', 'error');
                });
                
                deleteModal.classList.add('hidden');
            });
            
            // Form Submit Handler
            menuForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const menuId = document.getElementById('menuId').value;
                const url = menuId ? `/admin/menu/${menuId}` : '/admin/menu';
                const method = menuId ? 'POST' : 'POST';
                
                // Add CSRF token to headers
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast(menuId ? 'Menu updated successfully' : 'Menu created successfully');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast(error.message || 'Error saving menu', 'error');
                });
            });
            
            // Search and Filter Handlers
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const statusFilter = document.getElementById('statusFilter');
            
            function updateFilters() {
                const search = searchInput.value;
                const category = categoryFilter.value;
                const status = statusFilter.value;
                
                let url = new URL(window.location.href);
                url.searchParams.set('search', search);
                url.searchParams.set('category', category);
                url.searchParams.set('status', status);
                
                window.location.href = url.toString();
            }
            
            searchInput.addEventListener('input', debounce(updateFilters, 500));
            categoryFilter.addEventListener('change', updateFilters);
            statusFilter.addEventListener('change', updateFilters);
            
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        });
    </script>
</body>
</html>