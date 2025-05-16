<!DOCTYPE html>
<html lang="en">
<head>
    @vite([])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taru Martani - Register</title>
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
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(8px);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
            border-color: #667eea;
        }
        .floating-label {
            position: absolute;
            pointer-events: none;
            left: 12px;
            top: 12px;
            transition: 0.2s ease all;
            color: #6b7280;
            font-size: 14px;
        }
        .input-focused ~ .floating-label,
        input:not(:placeholder-shown) ~ .floating-label {
            top: -8px;
            left: 10px;
            font-size: 12px;
            background: white;
            padding: 0 4px;
            color: #667eea;
        }
        .btn-glow:hover {
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.5);
            transform: translateY(-2px);
        }
        @keyframes ripple {
            to {
                transform: scale(3);
                opacity: 0;
            }
        }
        .animate-ripple {
            animation: ripple 0.5s ease-out;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .floating-logo {
            animation: float 4s ease-in-out infinite;
        }
        .gradient-text {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .input-icon {
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .input-icon:hover {
            color: #667eea;
            transform: scale(1.2);
        }
        .error-shake {
            animation: shakeX 0.5s ease;
        }
        .focus-glow {
            transition: box-shadow 0.3s ease;
        }
        .focus-glow:focus {
            box-shadow: 0 0 10px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl overflow-hidden card-shadow p-8">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/overview/logotarumartani.webp') }}" alt="Taru Martani Logo" class="w-16 h-16 object-contain floating-logo animate__animated animate__fadeIn">
            </div>
            
            <h1 class="text-2xl font-semibold text-center gradient-text mb-2 animate__animated animate__fadeInDown">Create Your Account</h1>
            <p class="text-center text-gray-600 text-sm mb-6 animate__animated animate__fadeInUp">Join Taru Martani to get started</p>
            
            <form id="registerForm" class="space-y-5" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="relative animate__animated animate__fadeIn" data-animate-delay="0.1s">
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 input-focus focus:outline-none transition duration-200 placeholder-transparent focus-glow @error('name') is-invalid @enderror"
                        placeholder="Full Name"
                        value="{{ old('name') }}"
                        required
                    >
                    <label for="name" class="floating-label">Full Name</label>
                    <div class="absolute right-3 top-3 text-gray-500 input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    @error('name')
                    <div class="text-red-500 text-xs mt-1 invalid-feedback animate__animated animate__fadeIn">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="relative animate__animated animate__fadeIn" data-animate-delay="0.2s">
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 input-focus focus:outline-none transition duration-200 placeholder-transparent focus-glow @error('email') is-invalid @enderror"
                        placeholder="Email Address"
                        value="{{ old('email') }}"
                        required
                    >
                    <label for="email" class="floating-label">Email Address</label>
                    <div class="absolute right-3 top-3 text-gray-500 input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                    <div class="text-red-500 text-xs mt-1 invalid-feedback animate__animated animate__fadeIn">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="relative animate__animated animate__fadeIn" data-animate-delay="0.3s">
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 input-focus focus:outline-none transition duration-200 placeholder-transparent focus-glow @error('password') is-invalid @enderror"
                        placeholder="Password"
                        required
                    >
                    <label for="password" class="floating-label">Password</label>
                    <div class="absolute right-3 top-3 text-gray-500 cursor-pointer input-icon" id="togglePassword">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                    @error('password')
                    <div class="text-red-500 text-xs mt-1 invalid-feedback animate__animated animate__fadeIn">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="relative animate__animated animate__fadeIn" data-animate-delay="0.4s">
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        class="w-full px-3 py-2.5 rounded-lg border border-gray-300 input-focus focus:outline-none transition duration-200 placeholder-transparent focus-glow"
                        placeholder="Confirm Password"
                        required
                    >
                    <label for="password_confirmation" class="floating-label">Confirm Password</label>
                    <div class="absolute right-3 top-3 text-gray-500 cursor-pointer input-icon" id="toggleConfirmPassword">
                        <i class="fas fa-eye-slash"></i>
                    </div>
                </div>

                @if(session('error'))
                <div class="bg-red-50 border border-red-300 text-red-600 px-3 py-2 rounded text-sm animate__animated error-shake">
                    {{ session('error') }}
                </div>
                @endif
                
                <button 
                    type="submit" 
                    class="w-full py-2.5 px-4 rounded-lg text-white font-medium bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 btn-glow animate__animated animate__fadeIn" 
                    data-animate-delay="0.5s"
                    onclick="addRippleEffect(event)"
                >
                    Create Account
                </button>
            </form>
            
            <p class="text-center text-sm text-gray-600 mt-5 animate__animated animate__fadeIn" data-animate-delay="0.6s">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition">Sign in</a>
            </p>
        </div>
        
        <div class="mt-4 text-center text-xs text-white animate__animated animate__fadeIn" data-animate-delay="0.7s">
            © {{ date('Y') }} Taru Martani. All rights reserved.
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            togglePassword.addEventListener('click', function() {
                const icon = this.querySelector('i');
                passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye', passwordInput.type === 'text');
                icon.classList.toggle('fa-eye-slash', passwordInput.type === 'password');
            });

            toggleConfirmPassword.addEventListener('click', function() {
                const icon = this.querySelector('i');
                confirmPasswordInput.type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye', confirmPasswordInput.type === 'text');
                icon.classList.toggle('fa-eye-slash', confirmPasswordInput.type === 'password');
            });

            // Clear password fields on page load
            passwordInput.value = '';
            confirmPasswordInput.value = '';

            // Apply animation delays
            document.querySelectorAll('[data-animate-delay]').forEach(element => {
                element.style.animationDelay = element.dataset.animateDelay;
            });
        });

        function addRippleEffect(e) {
            const btn = e.currentTarget;
            const ripple = document.createElement('span');
            ripple.className = 'absolute bg-white/20 rounded-full transform scale-0 animate-ripple';
            ripple.style.width = ripple.style.height = '80px';
            ripple.style.top = `${e.offsetY - 40}px`;
            ripple.style.left = `${e.offsetX - 40}px`;
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 500);
        }
    </script>
</body>
</html>