<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Tarumartani Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        
        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .category-btn.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .order-item:hover {
            background-color: #f1f5f9;
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="gradient-bg text-white p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-utensils text-2xl"></i>
                    <h1 class="text-xl font-bold">Tarumartani Cafe</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.show') }}" class="relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if(session()->has('cart'))
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="container mx-auto mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="container mx-auto mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html> 