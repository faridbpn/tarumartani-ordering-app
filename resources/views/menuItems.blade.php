<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu Items - Admin Panel</title>
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
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        .order-row:hover {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    

  <!-- Sidebar -->
  <div class="sidebar gradient-bg text-white w-64 flex-shrink-0 hidden md:flex flex-col">
    <div class="p-4 flex items-center space-x-2">
      <i class="fas fa-utensils text-2xl"></i>
      <h1 class="text-xl font-bold">FoodExpress</h1>
    </div>
    
    <div class="flex-1 overflow-y-auto">
      <nav class="px-4 py-6 space-y-1">
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
          <i class="fas fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('menu.items') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg active-nav">
          <i class="fas fa-utensils"></i>
          <span>Menu Items</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
          <i class="fas fa-shopping-cart"></i>
          <span>Orders</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white hover:bg-opacity-10">
          <i class="fas fa-chart-line"></i>
          <span>Archive</span>
        </a>
      </nav>
    </div>
    
    <div class="p-4 border-t border-white border-opacity-20">
      <div class="flex items-center space-x-3">
        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Admin" class="w-10 h-10 rounded-full">
        <div>
          <p class="font-medium">Admin User</p>
          <p class="text-xs opacity-80">admin@foodexpress.com</p>
        </div>
      </div>
      <button class="w-full mt-4 py-2 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all">
        <i class="fas fa-sign-out-alt mr-2"></i> Logout
      </button>
    </div>
  </div>

  <!-- Main content -->
  <div class="flex-1 p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Menu Items</h1>
      <button onclick="openForm()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add New Item
      </button>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-100 text-gray-600">
          <tr>
            <th class="px-6 py-3">Image</th>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Category</th>
            <th class="px-6 py-3">Price</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody id="menuList" class="text-gray-700">
          <!-- Dynamic rows here -->
        </tbody>
      </table>
    </div>

    <!-- Modal Form -->
    <div id="formModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4" id="formTitle">Add New Item</h2>
        <form id="menuForm">
          <input type="hidden" id="editIndex">
          <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" id="itemName" class="w-full border rounded px-3 py-2" required>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Category</label>
            <input type="text" id="itemCategory" class="w-full border rounded px-3 py-2" required>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Price</label>
            <input type="number" id="itemPrice" class="w-full border rounded px-3 py-2" required>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Image URL</label>
            <input type="text" id="itemImage" class="w-full border rounded px-3 py-2">
          </div>
          <div class="flex justify-end space-x-2">
            <button type="button" onclick="closeForm()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS Section -->
  <script>
    const menuList = document.getElementById("menuList");
    const formModal = document.getElementById("formModal");
    const form = document.getElementById("menuForm");
    const itemName = document.getElementById("itemName");
    const itemCategory = document.getElementById("itemCategory");
    const itemPrice = document.getElementById("itemPrice");
    const itemImage = document.getElementById("itemImage");
    const editIndex = document.getElementById("editIndex");
    const formTitle = document.getElementById("formTitle");

    let menuItems = [];

    function renderMenu() {
      menuList.innerHTML = "";
      menuItems.forEach((item, index) => {
        menuList.innerHTML += `
          <tr class="border-b">
            <td class="px-6 py-4"><img src="${item.image || 'https://via.placeholder.com/40'}" class="w-10 h-10 rounded"/></td>
            <td class="px-6 py-4">${item.name}</td>
            <td class="px-6 py-4">${item.category}</td>
            <td class="px-6 py-4">$${item.price}</td>
            <td class="px-6 py-4">${item.status || "Available"}</td>
            <td class="px-6 py-4 text-center">
              <button onclick="editItem(${index})" class="text-blue-500 hover:underline mr-2">Edit</button>
              <button onclick="deleteItem(${index})" class="text-red-500 hover:underline">Delete</button>
            </td>
          </tr>
        `;
      });
    }

    function openForm() {
      form.reset();
      editIndex.value = "";
      formTitle.innerText = "Add New Item";
      formModal.classList.remove("hidden");
    }

    function closeForm() {
      formModal.classList.add("hidden");
    }

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const newItem = {
        name: itemName.value,
        category: itemCategory.value,
        price: parseFloat(itemPrice.value).toFixed(2),
        image: itemImage.value,
        status: "Available"
      };

      const index = editIndex.value;
      if (index) {
        menuItems[index] = newItem;
      } else {
        menuItems.push(newItem);
      }

      renderMenu();
      closeForm();
    });

    function editItem(index) {
      const item = menuItems[index];
      itemName.value = item.name;
      itemCategory.value = item.category;
      itemPrice.value = item.price;
      itemImage.value = item.image;
      editIndex.value = index;
      formTitle.innerText = "Edit Item";
      formModal.classList.remove("hidden");
    }

    function deleteItem(index) {
      if (confirm("Are you sure you want to delete this item?")) {
        menuItems.splice(index, 1);
        renderMenu();
      }
    }

    renderMenu(); // Initial render
    
  </script>
</body>
</html>
