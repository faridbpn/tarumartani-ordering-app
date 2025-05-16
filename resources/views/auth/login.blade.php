<!DOCTYPE html>
<html lang="en">
<head>
    @vite([])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taru Martani - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="{{ asset('images/overview/logotarumartani.webp') }}" type="image/svg+xml">
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
        .btn-glow:hover {
            box-shadow: 0 0 15px rgba(118, 75, 162, 0.6);
        }
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        .animate-ripple {
            animation: ripple 0.6s ease-out;
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
        .floating-logo {
            animation: float 3s ease-in-out infinite;
        }
        .gradient-text {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .input-icon {
            transition: transform 0.3s ease;
        }
        .input-icon:hover {
            transform: scale(1.2) rotate(10deg);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl overflow-hidden card-shadow">
            <div class="p-8">
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/overview/logotarumartani.webp') }}" alt="Taru Martani Logo" class="w-20 h-20 object-contain floating-logo animate__animated animate__zoomIn">
                </div>
                
                <h1 class="text-2xl font-bold text-center gradient-text mb-1 animate__animated animate__fadeInDown">Taru Martani</h1>
                <p class="text-center text-gray-500 mb-8 animate__animated animate__fadeInUp">Sign in to access your account</p>
                <form id="loginForm" class="space-y-6" method="POST" action="{{ route('submit.login') }}">
                    @csrf
                    <div class="relative animate__animated animate__fadeInLeft" data-animate-delay="0.2s">
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus focus:outline-none focus:border-indigo-500 transition duration-200 placeholder-transparent form-control @error('email') is-invalid @enderror"
                            placeholder="Email Address"
                            value="{{ old('email') }}"
                            required
                        >
                        <label for="email" class="floating-label">Email Address</label>
                        <div class="absolute right-3 top-3 text-gray-400 input-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        @error('email')
                        <div class="text-red-500 text-sm mt-1 invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="relative animate__animated animate__fadeInLeft" data-animate-delay="0.4s">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus focus:outline-none focus:border-indigo-500 transition duration-200 placeholder-transparent form-control @error('password') is-invalid @enderror"
                            placeholder="Password"
                            required
                        >
                        <label for="password" class="floating-label">Password</label>
                        <div class="absolute right-3 top-3 text-gray-400 cursor-pointer input-icon" id="togglePassword">
                            <i class="fas fa-eye-slash"></i>
                        </div>
                        @error('password')
                        <div class="text-red-500 text-sm mt-1 invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate__animated animate__shakeX" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center justify-between animate__animated animate__fadeInUp" data-animate-delay="0.6s">
                        <div class="flex items-center">
                            <input 
                                id="remember-me" 
                                name="remember"
                                type="checkbox" 
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button 
                            type="submit" 
                            class="flex-1 flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 btn-glow animate__animated animate__pulse animate__infinite"
                            onclick="addRippleEffect(event)"
                        >
                            Sign In
                            <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
                        </button>
                        <a 
                            href="{{ route('register') }}"
                            class="flex-1 flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 btn-glow animate__animated animate__pulse animate__infinite"
                            onclick="addRippleEffect(event)"
                        >
                            Sign Up
                            <i class="fas fa-user-plus ml-2 mt-0.5"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-6 text-center text-sm text-white animate__animated animate__fadeInUp animate__delay-1s">
            <p>© {{ date('Y') }} Taru Martani. All rights reserved.</p>
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

            // Add animation delay to form fields
            document.querySelectorAll('[data-animate-delay]').forEach(element => {
                element.style.animationDelay = element.dataset.animateDelay;
            });
        });

        function addRippleEffect(e) {
            e.preventDefault();
            const btn = e.currentTarget;
            const ripple = document.createElement('span');
            ripple.className = 'absolute bg-white/20 rounded-full transform scale-0 animate-ripple';
            ripple.style.width = ripple.style.height = '100px';
            ripple.style.top = `${e.offsetY - 50}px`;
            ripple.style.left = `${e.offsetX - 50}px`;
            btn.appendChild(ripple);
            setTimeout(() => {
                ripple.remove();
                if (btn.tagName === 'BUTTON') {
                    btn.closest('form').submit();
                } else if (btn.tagName === 'A') {
                    window.location.href = btn.href;
                }
            }, 600);
        }
    </script>
</body>
</html>