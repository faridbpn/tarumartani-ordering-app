<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Reservation - Taru Martani</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="{{ asset('images/overview/logotarumartani.webp') }}" type="image/svg+xml">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            position: relative;
            overflow: hidden;
        }
        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(0);
            transition: transform 0.3s ease;
            position: relative;
            cursor: grab;
            user-select: none;
        }
        .card-shadow:hover {
            transform: translateY(-5px);
        }
        .card-shadow:active {
            cursor: grabbing;
        }
        .btn-gradient {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-gradient:hover {
            background: linear-gradient(to right, #4338ca, #6d28d9);
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(79, 70, 229, 0.5);
        }
        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }
        .btn-gradient:hover::before {
            width: 300px;
            height: 300px;
        }
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        .slide-in {
            animation: slideIn 0.6s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(79, 70, 229, 0); }
            100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            animation: float 15s infinite linear;
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-100vh); }
            100% { transform: translateY(0); }
        }
        .icon-bounce {
            animation: iconBounce 1.5s ease-in-out infinite;
        }
        @keyframes iconBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center py-8 px-4">
    <!-- Particle Background -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="particle w-2 h-2 top-10 left-20"></div>
        <div class="particle w-3 h-3 top-40 left-40" style="animation-delay: -2s;"></div>
        <div class="particle w-2 h-2 top-60 right-20" style="animation-delay: -4s;"></div>
        <div class="particle w-3 h-3 bottom-20 left-60" style="animation-delay: -6s;"></div>
        <div class="particle w-2 h-2 bottom-40 right-40" style="animation-delay: -8s;"></div>
    </div>

    <div class="w-full max-w-2xl mx-auto fade-in">
        <div class="bg-white rounded-2xl overflow-hidden card-shadow relative" id="draggableCard">
            <div class="p-6 sm:p-8">
                <!-- Back to Home Button -->
                <div class="absolute top-4 left-4 slide-in">
                    <a href="/" class="inline-flex items-center px-4 py-2 btn-gradient text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 pulse text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Back to Home</span>
                    </a>
                </div>

                <div class="text-center">
                    <div class="mb-6 sm:mb-8 slide-in">
                        <i class="fas fa-check-circle text-5xl text-green-500 mb-4 icon-bounce"></i>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Reservation Submitted!</h1>
                        <p class="text-gray-600 text-sm sm:text-base">Thank you for your reservation request at Taru Martani.</p>
                        <p class="text-gray-600 text-sm sm:text-base mt-2">To confirm your booking, please contact our admin via WhatsApp.</p>
                    </div>

                    <div class="slide-in" style="animation-delay: 0.2s;">
                        <a href="https://wa.me/1234567890" target="_blank"
                           class="inline-flex items-center px-6 py-3 btn-gradient text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 pulse">
                            <i class="fab fa-whatsapp mr-2"></i>
                            <span>Chat with Admin</span>
                        </a>
                    </div>

                    <div class="mt-6 text-sm text-gray-500 slide-in" style="animation-delay: 0.4s;">
                        <p>Our team will assist you promptly to finalize your reservation details.</p>
                        <p class="mt-2">Need help? <a href="mailto:support@tarumartani.com" class="text-indigo-600 hover:text-indigo-800 underline">Email us</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const card = document.getElementById('draggableCard');
        let isDragging = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;

        card.addEventListener('mousedown', startDragging);
        card.addEventListener('touchstart', startDragging, { passive: false });

        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag, { passive: false });
        document.addEventListener('mouseup', stopDragging);
        document.addEventListener('touchend', stopDragging);

        function startDragging(e) {
            e.preventDefault();
            initialX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
            initialY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;

            isDragging = true;
        }

        function drag(e) {
            if (isDragging) {
                e.preventDefault();
                currentX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                currentY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;

                xOffset = currentX - initialX;
                yOffset = currentY - initialY;

                // Boundary constraints
                const rect = card.getBoundingClientRect();
                const maxX = window.innerWidth - rect.width;
                const maxY = window.innerHeight - rect.height;

                xOffset = Math.max(0, Math.min(xOffset, maxX));
                yOffset = Math.max(0, Math.min(yOffset, maxY));

                card.style.transform = `translate(${xOffset}px, ${yOffset}px)`;
            }
        }

        function stopDragging() {
            initialX = currentX;
            initialY = currentY;
            isDragging = false;
        }
    </script>
</body>
</html>