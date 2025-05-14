<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation - Taru Martani</title>
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
        }
        .card-shadow:hover {
            transform: translateY(-5px);
        }
        .input-focus {
            transition: all 0.3s ease;
            transform: scale(1);
        }
        .input-focus:focus, .input-focus:hover {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            transform: scale(1.02);
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

    <div class="w-full max-w-3xl mx-auto fade-in">
        <div class="bg-white rounded-2xl overflow-hidden card-shadow">
            <div class="p-6 sm:p-8">
                <div class="text-center mb-6 sm:mb-8 slide-in">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Make a Reservation</h1>
                    <p class="text-gray-600 text-sm sm:text-base">Book your table or event at Taru Martani</p>
                </div>

                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center slide-in" role="alert">
                    <i class="fas fa-check-circle mr-2 animate-bounce"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg slide-in" role="alert">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="reservationForm" action="{{ route('reservations.store') }}" method="POST" class="space-y-6" novalidate>
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="slide-in" style="animation-delay: 0.1s;">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                                placeholder="Enter your full name"
                                aria-required="true">
                            <p class="mt-1 text-xs text-red-600 hidden name-error">Please enter your full name.</p>
                        </div>
                        <div class="slide-in" style="animation-delay: 0.2s;">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                                placeholder="Enter your email"
                                aria-required="true">
                            <p class="mt-1 text-xs text-red-600 hidden email-error">Please enter a valid email address.</p>
                        </div>
                        <div class="slide-in" style="animation-delay: 0.3s;">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                                placeholder="Enter your phone number"
                                aria-required="true">
                            <p class="mt-1 text-xs text-red-600 hidden phone-error">Please enter a valid phone number (10-15 digits).</p>
                        </div>
                        <div class="slide-in" style="animation-delay: 0.4s;">
                            <label for="guest_count" class="block text-sm font-medium text-gray-700 mb-1">Number of Guests <span class="text-red-500">*</span></label>
                            <input type="number" name="guest_count" id="guest_count" min="1" max="50" value="{{ old('guest_count') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                                placeholder="Number of guests"
                                aria-required="true">
                            <p class="mt-1 text-xs text-red-600 hidden guest_count-error">Please enter a number between 1 and 50.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="slide-in" style="animation-delay: 0.5s;">
                            <label for="reservation_date" class="block text-sm font-medium text-gray-700 mb-1">Date <span class="text-red-500">*</span></label>
                            <input type="date" name="reservation_date" id="reservation_date" 
                                min="{{ date('Y-m-d') }}" value="{{ old('reservation_date') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                                aria-required="true">
                            <p class="mt-1 text-xs text-red-600 hidden reservation_date-error">Please select a future date.</p>
                        </div>
                        <div class="slide-in" style="animation-delay: 0.6s;">
                            <label for="reservation_time" class="block text-sm font-medium text-gray-700 mb-1">Time <span class="text-red-500">*</span></label>
                            <input type="time" name="reservation_time" id="reservation_time" 
                                min="10:00" max="22:00" value="{{ old('reservation_time') }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                                aria-required="true">
                            <p class="mt-1 text-xs text-red-600 hidden reservation_time-error">Please select a time between 10:00 and 22:00.</p>
                        </div>
                    </div>
                    <div class="slide-in" style="animation-delay: 0.7s;">
                        <label for="service_type" class="block text-sm font-medium text-gray-700 mb-1">Service Type <span class="text-red-500">*</span></label>
                        <select name="service_type" id="service_type" required
                            class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                            aria-required="true">
                            <option value="">Select a service type</option>
                            <option value="dinner" {{ old('service_type') == 'dinner' ? 'selected' : '' }}>Dinner Reservation</option>
                            <option value="lunch" {{ old('service_type') == 'lunch' ? 'selected' : '' }}>Lunch Reservation</option>
                            <option value="meeting" {{ old('service_type') == 'meeting' ? 'selected' : '' }}>Business Meeting</option>
                            <option value="wedding" {{ old('service_type') == 'wedding' ? 'selected' : '' }}>Wedding Event</option>
                            <option value="other" {{ old('service_type') == 'other' ? 'selected' : '' }}>Other Event</option>
                        </select>
                        <p class="mt-1 text-xs text-red-600 hidden service_type-error">Please select a service type.</p>
                    </div>
                    <div class="slide-in" style="animation-delay: 0.8s;">
                        <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                        <textarea name="special_requests" id="special_requests" rows="4"
                            class="block w-full rounded-lg border-gray-300 shadow-sm input-focus py-2 px-3 text-sm"
                            placeholder="Any special requests or requirements?">{{ old('special_requests') }}</textarea>
                    </div>
                    <div class="flex justify-end slide-in" style="animation-delay: 0.9s;">
                        <button type="submit"
                            class="px-6 py-3 btn-gradient text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center disabled:opacity-50 disabled:cursor-not-allowed pulse"
                            id="submitBtn">
                            <span>Submit Reservation</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                            <svg class="animate-spin h-5 w-5 ml-2 hidden" viewBox="0 0 24 24" id="loadingSpinner">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('reservation_date').min = today;

        // SweetAlert on success
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Reservation Submitted!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'rounded-xl animate-bounce',
                    confirmButton: 'bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg'
                }
            }).then(() => {
                window.location.href = '/';
            });
        @endif

        // Real-time form validation
        const form = document.getElementById('reservationForm');
        const submitBtn = document.getElementById('submitBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const inputs = form.querySelectorAll('input, select, textarea');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^\+?\d{10,15}$/;

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                validateField(input);
            });
            input.addEventListener('blur', () => {
                validateField(input);
            });
        });

        function validateField(input) {
            const errorElement = document.querySelector(`.${input.id}-error`);
            let isValid = true;

            if (input.required && !input.value.trim()) {
                isValid = false;
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500', 'animate-shake');
                setTimeout(() => input.classList.remove('animate-shake'), 500);
            } else if (input.id === 'email' && !emailRegex.test(input.value)) {
                isValid = false;
                errorElement.textContent = 'Please enter a valid email address.';
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500', 'animate-shake');
                setTimeout(() => input.classList.remove('animate-shake'), 500);
            } else if (input.id === 'phone' && !phoneRegex.test(input.value)) {
                isValid = false;
                errorElement.textContent = 'Please enter a valid phone number (10-15 digits).';
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500', 'animate-shake');
                setTimeout(() => input.classList.remove('animate-shake'), 500);
            } else if (input.id === 'guest_count' && (input.value < 1 || input.value > 50)) {
                isValid = false;
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500', 'animate-shake');
                setTimeout(() => input.classList.remove('animate-shake'), 500);
            } else if (input.id === 'reservation_date') {
                const selectedDate = new Date(input.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                if (selectedDate < today) {
                    isValid = false;
                    errorElement.classList.remove('hidden');
                    input.classList.add('border-red-500', 'animate-shake');
                    setTimeout(() => input.classList.remove('animate-shake'), 500);
                }
            } else if (input.id === 'reservation_time') {
                const time = input.value;
                if (time < '10:00' || time > '22:00') {
                    isValid = false;
                    errorElement.classList.remove('hidden');
                    input.classList.add('border-red-500', 'animate-shake');
                    setTimeout(() => input.classList.remove('animate-shake'), 500);
                }
            } else {
                errorElement.classList.add('hidden');
                input.classList.remove('border-red-500');
            }

            return isValid;
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            let isFormValid = true;

            inputs.forEach(input => {
                if (!validateField(input)) {
                    isFormValid = false;
                }
            });

            const date = document.getElementById('reservation_date').value;
            const time = document.getElementById('reservation_time').value;
            const selectedDateTime = new Date(`${date}T${time}`);
            const now = new Date();

            if (selectedDateTime < now) {
                isFormValid = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date/Time',
                    text: 'Please select a future date and time for your reservation.',
                    customClass: {
                        popup: 'rounded-xl animate-bounce',
                        confirmButton: 'bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg'
                    }
                });
            }

            if (isFormValid) {
                submitBtn.disabled = true;
                submitBtn.classList.add('animate-pulse');
                loadingSpinner.classList.remove('hidden');
                try {
                    // Simulate form submission
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    form.submit();
                } catch (error) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('animate-pulse');
                    loadingSpinner.classList.add('hidden');
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: 'An error occurred while submitting your reservation.',
                        customClass: {
                            popup: 'rounded-xl animate-bounce',
                            confirmButton: 'bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg'
                        }
                    });
                }
            }
        });

        // Add shake animation for errors
        const style = document.createElement('style');
        style.innerHTML = `
            .animate-shake {
                animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
            }
            @keyframes shake {
                10%, 90% { transform: translateX(-1px); }
                20%, 80% { transform: translateX(2px); }
                30%, 50%, 70% { transform: translateX(-4px); }
                40%, 60% { transform: translateX(4px); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>