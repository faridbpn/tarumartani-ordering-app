<!DOCTYPE html>
<html lang="en">
<head>
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
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md modal-content">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold" id="modalTitle">Add New Menu</h3>
                <button data-action="close-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="menuForm" class="p-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="menuId" name="id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price (Rp)</label>
                        <input type="number" name="price" id="price" required min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Availability</label>
                        <select name="is_available" id="is_available" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="1">Available</option>
                            <option value="0">Not Available</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <img id="imagePreview" class="mt-2 w-full h-32 object-cover rounded hidden" alt="Image Preview">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" data-action="close-modal"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
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
        document.addEventListener('DOMContentLoaded', () => {
            let currentMenuId = null;

            function showToast(message, isError = false) {
                const toast = document.getElementById('toast');
                if (!toast) {
                    console.error('Toast element not found');
                    return;
                }
                const toastMessage = document.getElementById('toastMessage');
                toastMessage.textContent = message;
                toast.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
                toast.classList.add(isError ? 'bg-red-500' : 'bg-green-500');
                setTimeout(() => toast.classList.add('hidden'), 3000);
            }

            // Image preview
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const preview = document.getElementById('imagePreview');
                    if (e.target.files && e.target.files[0]) {
                        preview.src = URL.createObjectURL(e.target.files[0]);
                        preview.classList.remove('hidden');
                    } else {
                        preview.classList.add('hidden');
                    }
                });
            } else {
                console.error('Image input not found');
            }

            function openAddModal() {
                console.log('Opening add modal');
                const modal = document.getElementById('menuModal');
                if (modal) {
                    document.getElementById('modalTitle').textContent = 'Add New Menu';
                    document.getElementById('menuForm').reset();
                    document.getElementById('menuId').value = '';
                    document.getElementById('imagePreview').classList.add('hidden');
                    modal.classList.remove('hidden');
                    modal.classList.add('active');
                    console.log('Add modal should be visible');
                } else {
                    console.error('menuModal not found');
                }
            }

            function openEditModal(id) {
                console.log(`Fetching menu data for ID: ${id}`);
                fetch(`/admin/menu/${id}`)
                    .then(response => {
                        console.log(`Fetch response status: ${response.status}`);
                        if (!response.ok) {
                            throw new Error(`Failed to fetch menu data: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(menu => {
                        console.log('Menu data:', menu);
                        const modal = document.getElementById('menuModal');
                        if (modal) {
                            document.getElementById('modalTitle').textContent = 'Edit Menu';
                            document.getElementById('menuId').value = menu.id;
                            document.getElementById('name').value = menu.name;
                            document.getElementById('description').value = menu.description || '';
                            document.getElementById('price').value = menu.price;
                            document.getElementById('category_id').value = menu.category_id;
                            document.getElementById('is_available').value = menu.is_available ? '1' : '0';
                            document.getElementById('imagePreview').src = menu.image ? `/storage/${menu.image}` : '';
                            document.getElementById('imagePreview').classList.toggle('hidden', !menu.image);
                            modal.classList.remove('hidden');
                            modal.classList.add('active');
                            console.log('Edit modal should be visible');
                        } else {
                            console.error('menuModal not found');
                        }
                    })
                    .catch(error => {
                        showToast('Failed to load menu data', true);
                        console.error('Fetch error:', error);
                    });
            }

            function closeModal() {
                console.log('Closing add/edit modal');
                const modal = document.getElementById('menuModal');
                if (modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('active');
                    document.getElementById('imagePreview').classList.add('hidden');
                } else {
                    console.error('menuModal not found');
                }
            }

            function confirmDelete(id) {
                console.log(`Opening delete modal for ID: ${id}`);
                currentMenuId = id;
                const deleteModal = document.getElementById('deleteModal');
                if (deleteModal) {
                    deleteModal.classList.remove('hidden');
                    deleteModal.classList.add('active');
                    console.log('Delete modal should be visible');
                } else {
                    console.error('deleteModal not found');
                }
            }

            function closeDeleteModal() {
                console.log('Closing delete modal');
                const deleteModal = document.getElementById('deleteModal');
                if (deleteModal) {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('active');
                    currentMenuId = null;
                } else {
                    console.error('deleteModal not found');
                }
            }

            function deleteMenu() {
                console.log(`Deleting menu ID: ${currentMenuId}`);
                if (!currentMenuId) return;

                fetch(`/admin/menu/${currentMenuId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        console.log(`Delete response status: ${response.status}`);
                        if (!response.ok) {
                            throw new Error('Failed to delete menu');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            closeDeleteModal();
                            showToast('Menu deleted successfully');
                            location.reload();
                        } else {
                            showToast(data.message || 'Failed to delete menu', true);
                        }
                    })
                    .catch(error => {
                        showToast('Error deleting menu', true);
                        console.error('Delete error:', error);
                    });
            }

            // Search and Filter functionality
            function filterMenus() {
                const search = document.getElementById('searchInput').value.toLowerCase();
                const category = document.getElementById('categoryFilter').value;
                const status = document.getElementById('statusFilter').value;

                document.querySelectorAll('.menu-card').forEach(card => {
                    const name = card.querySelector('h3').textContent.toLowerCase();
                    const cardCategory = card.querySelector('.text-gray-500').getAttribute('data-category-id') || '';
                    const cardStatus = card.querySelector('.rounded-full').textContent.includes('Available') ? '1' : '0';

                    const matchesSearch = name.includes(search);
                    const matchesCategory = !category || cardCategory === category;
                    const matchesStatus = !status || cardStatus === status;

                    card.style.display = matchesSearch && matchesCategory && matchesStatus ? 'block' : 'none';
                });
            }

            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', filterMenus);
            } else {
                console.error('searchInput not found');
            }

            const categoryFilter = document.getElementById('categoryFilter');
            if (categoryFilter) {
                categoryFilter.addEventListener('change', filterMenus);
            } else {
                console.error('categoryFilter not found');
            }

            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', filterMenus);
            } else {
                console.error('statusFilter not found');
            }

            const menuForm = document.getElementById('menuForm');
            if (menuForm) {
                menuForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const id = document.getElementById('menuId').value;
                    const url = id ? `/admin/menu/${id}` : '/admin/menu';
                    const method = id ? 'POST' : 'POST';
                    if (id) formData.append('_method', 'PUT');

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            console.log(`Form submit response status: ${response.status}`);
                            if (!response.ok) {
                                throw new Error('Failed to save menu');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                closeModal();
                                showToast(id ? 'Menu updated successfully' : 'Menu created successfully');
                                location.reload();
                            } else {
                                showToast(data.message || 'Failed to save menu', true);
                            }
                        })
                        .catch(error => {
                            showToast('Error saving menu', true);
                            console.error('Form submit error:', error);
                        });
                });
            } else {
                console.error('menuForm not found');
            }

            // Sidebar toggle for mobile
            const sidebarToggle = document.getElementById('sidebar-toggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    document.querySelector('.sidebar').classList.toggle('hidden');
                });
            } else {
                console.error('sidebar-toggle not found');
            }

            // Attach event listeners to buttons
            const addButton = document.querySelector('[data-action="add-menu"]');
            if (addButton) {
                console.log('Add button found');
                addButton.addEventListener('click', () => {
                    console.log('Add button clicked');
                    openAddModal();
                });
            } else {
                console.error('Add button not found');
            }

            document.querySelectorAll('[data-action="edit-menu"]').forEach(button => {
                const id = button.getAttribute('data-id');
                console.log(`Edit button found for ID: ${id}`);
                button.addEventListener('click', () => {
                    console.log(`Edit button clicked for ID: ${id}`);
                    openEditModal(id);
                });
            });

            document.querySelectorAll('[data-action="delete-menu"]').forEach(button => {
                const id = button.getAttribute('data-id');
                console.log(`Delete button found for ID: ${id}`);
                button.addEventListener('click', () => {
                    console.log(`Delete button clicked for ID: ${id}`);
                    confirmDelete(id);
                });
            });

            const closeModalButton = document.querySelector('[data-action="close-modal"]');
            if (closeModalButton) {
                closeModalButton.addEventListener('click', closeModal);
            } else {
                console.error('close-modal button not found');
            }

            const closeDeleteModalButton = document.querySelector('[data-action="close-delete-modal"]');
            if (closeDeleteModalButton) {
                closeDeleteModalButton.addEventListener('click', closeDeleteModal);
            } else {
                console.error('close-delete-modal button not found');
            }

            const confirmDeleteButton = document.querySelector('[data-action="confirm-delete"]');
            if (confirmDeleteButton) {
                confirmDeleteButton.addEventListener('click', deleteMenu);
            } else {
                console.error('confirm-delete button not found');
            }
        });
    </script>
</body>
</html>