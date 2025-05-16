<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Taru Martani</title>
  
  <!-- Tailwind & Animate CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <style>
    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0); }
    }
    .floating { animation: float 3s ease-in-out infinite; }
    .gradient-text {
      background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .btn-glow:hover {
      box-shadow: 0 0 15px rgba(59, 130, 246, 0.6);
    }
  </style>
</head>
<body class="bg-gradient-to-br from-white to-gray-800 min-h-screen flex items-center justify-center p-6">

  <!-- Card Container -->
  <div class="bg-gray-800/60 border border-gray-700/50 backdrop-blur-lg shadow-2xl rounded-2xl p-10 max-w-xl text-center relative overflow-hidden w-full">
    <!-- Decorative Bubbles -->
    <div class="absolute w-40 h-40 bg-blue-500/10 rounded-full top-[-60px] left-[-60px] animate-pulse"></div>
    <div class="absolute w-60 h-60 bg-purple-500/10 rounded-full bottom-[-80px] right-[-80px] animate-pulse"></div>

    <!-- Title -->
    <h1 class="text-4xl font-bold gradient-text animate__animated animate__fadeIn pb-2">Register</h1>
    <p class="text-gray-300 text-lg mt-2 animate__animated animate__fadeInUp animate__delay-1s">
      Sign up to create your Taru Martani account
    </p>

    <!-- Form -->
    <form method="POST" action="{{ route('register.submit') }}" class="mt-6 space-y-4 animate__animated animate__fadeInUp animate__delay-1s">
      @csrf
      <div>
        <input type="text" name="name" id="name" placeholder="Name" required class="w-full px-4 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600">
      </div>
      <div>
        <input type="email" name="email" id="email" placeholder="Email Address" required class="w-full px-4 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600">
      </div>
      <div>
        <input type="password" name="password" id="password" placeholder="Password" required class="w-full px-4 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600">
      </div>
      <div>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required class="w-full px-4 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600">
      </div>
      <button type="submit" class="btn-glow relative group w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full text-white font-semibold text-lg transition-all hover:scale-105 shadow-lg overflow-hidden">
        <span class="relative z-10 flex items-center justify-center gap-2">
          <i class="fas fa-user-plus"></i>
          Register
        </span>
        <span class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-full"></span>
      </button>
    </form>

    <!-- Login Link -->
    <p class="text-sm text-gray-500 mt-6 animate__animated animate__fadeInUp animate__delay-2s">
      Already have an account? 
      <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition">Login here</a>
    </p>

    <!-- Footer -->
    <p class="text-xs text-gray-500 mt-6">© 2025 Taru Martani. All rights reserved.</p>
  </div>

  <script>
    function redirectWithEffect(e) {
      e.preventDefault();

      const btn = e.currentTarget;
      const ripple = document.createElement('span');
      ripple.className = 'absolute bg-white/20 rounded-full transform scale-0';
      ripple.style.width = ripple.style.height = '100px';
      ripple.style.top = `${e.offsetY - 50}px`;
      ripple.style.left = `${e.offsetX - 50}px`;
      ripple.style.animation = 'ripple 0.6s ease-out';

      btn.appendChild(ripple);
      setTimeout(() => {
        ripple.remove();
        window.location.href = "{{ route('register.submit') }}";
      }, 600);
    }
  </script>

  <style>
    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
    .animate-ripple {
      animation: ripple 0.6s ease-out;
    }
  </style>
</body>
</html>