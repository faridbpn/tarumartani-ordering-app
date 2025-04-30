<!DOCTYPE html>
<html lang="en">
<head>
    @vite([])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.3);
        }
        .floating-label {
            position: absolute;
            pointer-events: none;
            left: 15px;
            top: 11px;
            transition: 0.2s ease all;
            color: #9ca3af;
        }
        .input-focused ~ .floating-label,
        input:not(:placeholder-shown) ~ .floating-label {
            top: -8px;
            left: 10px;
            font-size: 12px;
            background: white;
            padding: 0 5px;
            color: #667eea;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl overflow-hidden card-shadow">
            <div class="p-8">
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-lock text-white text-3xl"></i>
                    </div>
                </div>
                
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-1">Admin Portal</h1>
                <p class="text-center text-gray-500 mb-8">Sign in to your account</p>
                <form id="loginForm" class="space-y-6" method="POST" action="{{ route('submit.login') }}">
                    @csrf
                    <div class="relative">
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus focus:outline-none focus:border-indigo-500 transition duration-200 placeholder-transparent form-control @error('email') is-invalid @enderror"
                            placeholder="Email Address"
                            required
                        >
                        <label for="email" class="floating-label">Email Address</label>
                        <div class="absolute right-3 top-3 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>

                        @error('email')
                        <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus focus:outline-none focus:border-indigo-500 transition duration-200 placeholder-transparent form-control @error('password') is-invalid @enderror"
                            placeholder="Password"
                            required
                        >
                        <label for="password" class="floating-label">Password</label>
                        <div class="absolute right-3 top-3 text-gray-400 cursor-pointer" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </div>
                        @error('password')
                        <div class="text-red-500 text-sm mt-1 hidden invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember-me" 
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                        
                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200"
                    >
                        Sign in
                        <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
                    </button>
                </form>
            </div>
            
            <div class="bg-gray-50 px-8 py-6 rounded-b-2xl">
                <div class="text-center text-sm text-gray-500">
                    Don't have an account? 
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Contact administrator
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center text-sm text-white">
            <p>© 2023 Admin Portal. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            togglePassword.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                }
            });

            // Clear password field on page load
            passwordInput.value = '';
        });
    </script>
</body>
</html>