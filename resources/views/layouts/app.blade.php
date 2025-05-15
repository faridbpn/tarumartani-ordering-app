<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FoodExpress - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Pastikan Vite mengelola Tailwind CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar gradient-bg text-white w-64 flex-shrink-0 flex flex-col">
            <div class="p-4 flex items-center space-x-2">
                <i class="fas fa-utensils text-2xl"></i>
                <h1 class="text-xl font-bold">FoodExpress</h1>
            </div>

            <div class="flex-1 overflow-y-auto">
                <nav class="px-4 py-6 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                           {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('menu.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('menu.index') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-utensils"></i>
                        <span>Menu</span>
                    </a>
                    <a href="{{ route('orders.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('orders.index') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                    <a href="{{ route('arsip.index') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('arsip.index') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-users"></i>
                        <span>History</span>
                    </a>
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('admin.users') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-user"></i>
                        <span>User List</span>
                    </a>
                    <a href="{{ route('userReservation') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                        {{ request()->routeIs('userReservation') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-users"></i>
                        <span>Reservasi</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-white border-opacity-20">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/overview/bes seler.webp') }}" alt="Admin" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-medium">admin@gmail.com</p>
                        <p class="text-xs opacity-80">bang admin</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="w-full mt-4">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>
    </div>
</body>
</html>