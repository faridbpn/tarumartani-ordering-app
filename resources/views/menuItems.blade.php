<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management - FoodExpress Admin</title>
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
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
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
                <h2 class="text-xl font-bold text-gray-800">Menu Management</h2>
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
                    <input type="text" placeholder="Search menu items..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button id="add-menu-btn" class="px-4 py-2 gradient-bg text-white rounded-lg hover:opacity-90 transition-all">
                        <i class="fas fa-plus mr-2"></i> Add Menu
                    </button>
                    <select class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Categories</option>
                        <option>Main Course</option>
                        <option>Appetizers</option>
                        <option>Desserts</option>
                        <option>Beverages</option>
                    </select>
                    <select class="border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option>All Status</option>
                        <option>Available</option>
                        <option>Out of Stock</option>
                        <option>Seasonal</option>
                    </select>
                </div>
            </div>
            
            <!-- Category Tabs -->
            <div class="flex overflow-x-auto mb-6 bg-white rounded-xl shadow p-1">
                <button class="category-tab active px-4 py-2 rounded-lg font-medium transition-all">All Items</button>
                <button class="category-tab px-4 py-2 rounded-lg font-medium transition-all">Main Course</button>
                <button class="category-tab px-4 py-2 rounded-lg font-medium transition-all">Appetizers</button>
                <button class="category-tab px-4 py-2 rounded-lg font-medium transition-all">Desserts</button>
                <button class="category-tab px-4 py-2 rounded-lg font-medium transition-all">Beverages</button>
                <button class="category-tab px-4 py-2 rounded-lg font-medium transition-all">Specials</button>
            </div>
            
            <!-- Menu Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Menu Item 1 -->
                <div class="menu-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1198&q=80')"></div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Nasi Goreng Special</h3>
                            <span class="text-green-600 font-bold">$8.99</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Traditional Indonesian fried rice with special sauce, chicken, and prawns.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="status-badge bg-green-100 text-green-800">Available</span>
                                <span class="text-xs text-gray-500 ml-2">Main Course</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="edit-menu-btn p-2 text-blue-500 hover:bg-blue-50 rounded-lg" data-id="1">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-menu-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 2 -->
                <div class="menu-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1071&q=80')"></div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Sate Ayam</h3>
                            <span class="text-green-600 font-bold">$6.50</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Grilled chicken skewers with peanut sauce, served with rice cakes.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="status-badge bg-green-100 text-green-800">Available</span>
                                <span class="text-xs text-gray-500 ml-2">Appetizer</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="edit-menu-btn p-2 text-blue-500 hover:bg-blue-50 rounded-lg" data-id="2">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-menu-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 3 -->
                <div class="menu-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=927&q=80')"></div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Es Campur</h3>
                            <span class="text-green-600 font-bold">$4.99</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Mixed ice dessert with fruits, jelly, syrup, and condensed milk.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="status-badge bg-yellow-100 text-yellow-800">Seasonal</span>
                                <span class="text-xs text-gray-500 ml-2">Dessert</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="edit-menu-btn p-2 text-blue-500 hover:bg-blue-50 rounded-lg" data-id="3">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-menu-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="3">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 4 -->
                <div class="menu-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1510626176961-4b1d6946d2bd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80')"></div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Soto Betawi</h3>
                            <span class="text-green-600 font-bold">$7.25</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Jakarta-style beef soup with coconut milk, served with rice.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="status-badge bg-red-100 text-red-800">Out of Stock</span>
                                <span class="text-xs text-gray-500 ml-2">Main Course</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="edit-menu-btn p-2 text-blue-500 hover:bg-blue-50 rounded-lg" data-id="4">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-menu-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="4">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 5 -->
                <div class="menu-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1551024506-0bccd828d307?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80')"></div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Es Teh Manis</h3>
                            <span class="text-green-600 font-bold">$2.50</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Sweet iced tea with lemon, perfect Indonesian-style refreshment.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="status-badge bg-green-100 text-green-800">Available</span>
                                <span class="text-xs text-gray-500 ml-2">Beverage</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="edit-menu-btn p-2 text-blue-500 hover:bg-blue-50 rounded-lg" data-id="5">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-menu-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="5">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Menu Item 6 -->
                <div class="menu-card bg-white rounded-xl shadow overflow-hidden">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1071&q=80')"></div>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg">Gado-Gado</h3>
                            <span class="text-green-600 font-bold">$5.99</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Indonesian salad with mixed vegetables, tofu, tempeh and peanut sauce.</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="status-badge bg-green-100 text-green-800">Available</span>
                                <span class="text-xs text-gray-500 ml-2">Appetizer</span>
                            </div>
                            <div class="flex space-x-2">
                                <button class="edit-menu-btn p-2 text-blue-500 hover:bg-blue-50 rounded-lg" data-id="6">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete-menu-btn p-2 text-red-500 hover:bg-red-50 rounded-lg" data-id="6">
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

    <!-- Add/Edit Menu Modal -->
    <div id="menu-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-xl shadow-lg w-full max-w-2xl overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold" id="modal-title">Add New Menu Item</h3>
                <button id="close-menu-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-4 overflow-y-auto max-h-[80vh]">
                <form id="menu-form">
                    <input type="hidden" id="menu-item-id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="menu-name" class="block text-sm font-medium text-gray-700 mb-1">Menu Name</label>
                            <input type="text" id="menu-name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <label for="menu-price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <input type="number" id="menu-price" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="menu-category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select id="menu-category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Category</option>
                                <option value="main-course">Main Course</option>
                                <option value="appetizer">Appetizer</option>
                                <option value="dessert">Dessert</option>
                                <option value="beverage">Beverage</option>
                                <option value="special">Special</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="menu-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="menu-status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="available">Available</option>
                                <option value="out-of-stock">Out of Stock</option>
                                <option value="seasonal">Seasonal</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="menu-description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="menu-description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Menu Image</label>
                        <div class="mt-1 flex items-center">
                            <div id="image-preview" class="image-upload-preview w-32 h-32 rounded-lg bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No image</span>
                            </div>
                            <div class="ml-4">
                                <input type="file" id="menu-image" class="hidden" accept="image/*">
                                <button type="button" id="upload-btn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <i class="fas fa-upload mr-2"></i> Upload Image
                                </button>
                                <p class="mt-1 text-xs text-gray-500">JPG, PNG up to 2MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" id="cancel-menu-btn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                        <button type="submit" id="save-menu-btn" class="px-4 py-2 gradient-bg text-white rounded-lg hover:opacity-90">Save Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-xl shadow-lg w-full max-w-md overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold">Confirm Deletion</h3>
                <button id="close-delete-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-4">
                <p class="mb-4">Are you sure you want to delete this menu item? This action cannot be undone.</p>
                <input type="hidden" id="delete-item-id">
                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancel-delete-btn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="button" id="confirm-delete-btn" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
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
            const menuModal = document.getElementById('menu-modal');
            const deleteModal = document.getElementById('delete-modal');
            const addMenuBtn = document.getElementById('add-menu-btn');
            const editMenuBtns = document.querySelectorAll('.edit-menu-btn');
            const deleteMenuBtns = document.querySelectorAll('.delete-menu-btn');
            const closeMenuModalBtns = [document.getElementById('close-menu-modal'), document.getElementById('cancel-menu-btn')];
            const closeDeleteModalBtns = [document.getElementById('close-delete-modal'), document.getElementById('cancel-delete-btn')];
            const saveMenuBtn = document.getElementById('save-menu-btn');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const menuForm = document.getElementById('menu-form');
            const uploadBtn = document.getElementById('upload-btn');
            const menuImageInput = document.getElementById('menu-image');
            const imagePreview = document.getElementById('image-preview');
            
            // Category tabs
            const categoryTabs = document.querySelectorAll('.category-tab');
            
            // Sample data for demonstration
            let menuItems = [
                { 
                    id: 1, 
                    name: 'Nasi Goreng Special', 
                    price: 8.99, 
                    category: 'main-course', 
                    status: 'available', 
                    description: 'Traditional Indonesian fried rice with special sauce, chicken, and prawns.', 
                    image: 'https://images.unsplash.com/photo-1559847844-5315695dadae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1198&q=80' 
                },
                { 
                    id: 2, 
                    name: 'Sate Ayam', 
                    price: 6.50, 
                    category: 'appetizer', 
                    status: 'available', 
                    description: 'Grilled chicken skewers with peanut sauce, served with rice cakes.', 
                    image: 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1071&q=80' 
                },
                { 
                    id: 3, 
                    name: 'Es Campur', 
                    price: 4.99, 
                    category: 'dessert', 
                    status: 'seasonal', 
                    description: 'Mixed ice dessert with fruits, jelly, syrup, and condensed milk.', 
                    image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=927&q=80' 
                },
                { 
                    id: 4, 
                    name: 'Soto Betawi', 
                    price: 7.25, 
                    category: 'main-course', 
                    status: 'out-of-stock', 
                    description: 'Jakarta-style beef soup with coconut milk, served with rice.', 
                    image: 'https://images.unsplash.com/photo-1510626176961-4b1d6946d2bd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80' 
                },
                { 
                    id: 5, 
                    name: 'Es Teh Manis', 
                    price: 2.50, 
                    category: 'beverage', 
                    status: 'available', 
                    description: 'Sweet iced tea with lemon, perfect Indonesian-style refreshment.', 
                    image: 'https://images.unsplash.com/photo-1551024506-0bccd828d307?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80' 
                },
                { 
                    id: 6, 
                    name: 'Gado-Gado', 
                    price: 5.99, 
                    category: 'appetizer', 
                    status: 'available', 
                    description: 'Indonesian salad with mixed vegetables, tofu, tempeh and peanut sauce.', 
                    image: 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1071&q=80' 
                }
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
            
            // Category tabs
            categoryTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    // In a real app, you would filter menu items by category here
                });
            });
            
            // Add new menu
            addMenuBtn.addEventListener('click', function() {
                document.getElementById('modal-title').textContent = 'Add New Menu Item';
                document.getElementById('menu-item-id').value = '';
                menuForm.reset();
                imagePreview.style.backgroundImage = 'none';
                imagePreview.innerHTML = '<span class="text-gray-500">No image</span>';
                toggleModal(menuModal, true);
            });
            
            // Edit menu
            editMenuBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = parseInt(this.getAttribute('data-id'));
                    const menuItem = menuItems.find(item => item.id === itemId);
                    
                    if (menuItem) {
                        document.getElementById('modal-title').textContent = 'Edit Menu Item';
                        document.getElementById('menu-item-id').value = menuItem.id;
                        document.getElementById('menu-name').value = menuItem.name;
                        document.getElementById('menu-price').value = menuItem.price;
                        document.getElementById('menu-category').value = menuItem.category;
                        document.getElementById('menu-status').value = menuItem.status;
                        document.getElementById('menu-description').value = menuItem.description;
                        
                        if (menuItem.image) {
                            imagePreview.style.backgroundImage = `url('${menuItem.image}')`;
                            imagePreview.innerHTML = '';
                        } else {
                            imagePreview.style.backgroundImage = 'none';
                            imagePreview.innerHTML = '<span class="text-gray-500">No image</span>';
                        }
                        
                        toggleModal(menuModal, true);
                    }
                });
            });
            
            // Delete menu
            deleteMenuBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const itemId = parseInt(this.getAttribute('data-id'));
                    document.getElementById('delete-item-id').value = itemId;
                    toggleModal(deleteModal, true);
                });
            });
            
            // Close modals
            closeMenuModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    toggleModal(menuModal, false);
                });
            });
            
            closeDeleteModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    toggleModal(deleteModal, false);
                });
            });
            
            // Image upload
            uploadBtn.addEventListener('click', function() {
                menuImageInput.click();
            });
            
            menuImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imagePreview.style.backgroundImage = `url('${event.target.result}')`;
                        imagePreview.innerHTML = '';
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            // Save menu
            menuForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const itemId = document.getElementById('menu-item-id').value;
                const menuItem = {
                    name: document.getElementById('menu-name').value,
                    price: parseFloat(document.getElementById('menu-price').value),
                    category: document.getElementById('menu-category').value,
                    status: document.getElementById('menu-status').value,
                    description: document.getElementById('menu-description').value,
                    image: imagePreview.style.backgroundImage !== 'none' ? 
                          imagePreview.style.backgroundImage.slice(4, -1).replace(/"/g, "") : ''
                };
                
                if (itemId) {
                    // Update existing item
                    const index = menuItems.findIndex(item => item.id === parseInt(itemId));
                    if (index !== -1) {
                        menuItems[index] = { ...menuItems[index], ...menuItem };
                    }
                    alert('Menu updated successfully!');
                } else {
                    // Add new item
                    const newId = menuItems.length > 0 ? Math.max(...menuItems.map(item => item.id)) + 1 : 1;
                    menuItems.push({ id: newId, ...menuItem });
                    alert('Menu added successfully!');
                }
                
                toggleModal(menuModal, false);
                // In a real app, you would refresh the menu list here
            });
            
            // Confirm delete
            confirmDeleteBtn.addEventListener('click', function() {
                const itemId = parseInt(document.getElementById('delete-item-id').value);
                
                // In a real app, you would send delete request to server here
                menuItems = menuItems.filter(item => item.id !== itemId);
                alert('Menu deleted successfully!');
                toggleModal(deleteModal, false);
                
                // In a real app, you would refresh the menu list here
            });
        });
    </script>
</body>
</html>