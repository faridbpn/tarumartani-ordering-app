<!DOCTYPE html>
<html lang="en">
<head>
    @vite([])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl overflow-hidden card-shadow">
            <div class="p-8">
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center">
                        <i class="fas fa-envelope text-white text-3xl"></i>
                    </div>
                </div>
                
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-1">Enter Your Details</h1>
                <p class="text-center text-gray-500 mb-8">Please provide your email and name</p>
                
                <form id="emailForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" id="token" value="{{ session('token') }}">
                    <input type="hidden" name="nomor_meja" id="nomor_meja" value="{{ session('nomor_meja') }}">
                    
                    <div class="relative">
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus focus:outline-none focus:border-indigo-500 transition duration-200 placeholder-transparent"
                            placeholder="Email Address"
                            required
                        >
                        <label for="email" class="floating-label">Email Address</label>
                        <div class="absolute right-3 top-3 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus focus:outline-none focus:border-indigo-500 transition duration-200 placeholder-transparent"
                            placeholder="Full Name"
                            required
                        >
                        <label for="name" class="floating-label">Full Name</label>
                        <div class="absolute right-3 top-3 text-gray-400">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <button 
                            type="button" 
                            class="py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200"
                            onclick="closeEmailModal()"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200"
                        >
                            Submit
                            <i class="fas fa-arrow-right ml-2 mt-0.5"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-gray-50 px-8 py-6 rounded-b-2xl">
                <div class="text-center text-sm text-gray-500">
                    Need assistance? 
                    <a href="https loads://wa.me/6281380464576" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Contact support
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center text-sm text-white">
            <p>© 2025 All rights reserved.</p>
        </div>
    </div>

    <script>
        function openEmailModal() {
            document.body.classList.add('flex', 'items-center', 'justify-center');
        }

        function closeEmailModal() {
            window.location.href = "{{ route('menu.meja.index') }}"; // Redirect to menu on cancel
        }

        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var email = document.getElementById('email').value;
            var name = document.getElementById('name').value;
            var token = document.getElementById('token').value;
            var nomor_meja = document.getElementById('nomor_meja').value;

            $.post("{{ route('save.email.meja') }}", {
                email: email,
                name: name,
                token: token,
                nomor_meja: nomor_meja,
                _token: '{{ csrf_token() }}'
            })
            .done(function(response) {
                console.log(response);
                if (response.status === 'success') {
                    closeEmailModal();
                }
            })
            .fail(function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Gagal menyimpan data.',
                });
            });
        });

        // Open modal on page load
        document.addEventListener('DOMContentLoaded', function() {
            openEmailModal();
        });
    </script>
</body>
</html>