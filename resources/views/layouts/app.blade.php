@vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Tambahkan baris ini -->

<div class="sidebar gradient-bg text-white w-64 flex-shrink-0 hidden md:flex flex-col">
    <div class="p-4 flex items-center space-x-2">
        <i class="fas fa-utensils text-2xl"></i>
        <h1 class="text-xl font-bold">FoodExpress</h1>
    </div>

    <div class="flex-1 overflow-y-auto">
        <nav class="px-4 py-6 space-y-1">
            {{-- admin --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                   {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            {{-- menu management --}}
            <a href="{{ route('menu.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                {{ request()->routeIs('menu.index') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                <i class="fas fa-utensils"></i>
                <span>Menu</span>
            </a>
            {{-- orders --}}
            <a href="{{ route('orders.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                {{ request()->routeIs('orders.index') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
            </a>
            {{-- reservation --}}
            <a href="{{ route('admin.reservations') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg 
               {{ request()->routeIs('admin.reservations') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
               <i class="fas fa-bookmark"></i>
               <span>Reservasi</span>
           </a>
            {{-- user management --}}
            <a href="{{ route('admin.users') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                {{ request()->routeIs('admin.users') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                <i class="fas fa-user"></i>
                <span>User List</span>
            </a>
             {{-- orders --}}
             <a href="{{ route('arsip.index') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                {{ request()->routeIs('arsip.index') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }}">
                <i class="fas fa-clock-rotate-left"></i>
                <span>History</span>
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
            <button type="submit" class="w-full py-2 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
        
    </div>
</div>

