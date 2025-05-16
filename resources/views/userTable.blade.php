<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('images/overview/logotarumartani.webp') }}" type="image/svg+xml">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .floating-cart-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .floating-cart-btn:hover {
            transform: translateY(-2px);
        }
        .image-popup {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .image-popup img {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
        }
        .image-popup-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 24px;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        .image-popup-close:hover {
            background: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Categories</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                <button class="category-btn px-4 py-2 rounded-full bg-gray-200 hover:bg-blue-500 hover:text-white transition-all" data-category="all">
                    All
                </button>
                @foreach($categories as $category)
                    <button class="category-btn px-4 py-2 rounded-full bg-gray-200 hover:bg-blue-500 hover:text-white transition-all" data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($menuItems as $item)
                        @if($item->is_available)
                        <div class="food-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300" data-category="{{ $item->category_id }}">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/300x200' }}" 
                                alt="{{ $item->name }}" 
                                class="w-full h-48 object-cover cursor-pointer menu-image"
                                data-image="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/300x200' }}">
                            <div class="p-4">
                                <span class="text-xs text-gray-500 mb-1 block">{{ $item->category->name }}</span>
                                <h3 class="text-lg font-semibold mb-2">{{ $item->name }}</h3>
                                <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold text-blue-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <button class="add-to-cart-btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors" 
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"
                                            data-price="{{ $item->price }}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="lg:w-1/3">
                <div id="order-summary" class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Your Order</h2>
                    <div id="order-items" class="mb-4 max-h-96 overflow-y-auto">
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-shopping-cart text-4xl mb-2 text-gray-300"></i>
                            <p>Your cart is empty</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span id="subtotal" class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Tax (10%):</span>
                            <span id="tax" class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Service Charge (5%):</span>
                            <span id="service" class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-3">
                            <span>Total:</span>
                            <span id="total" class="text-blue-600">Rp 0</span>
                        </div>
                    </div>
                    <button id="checkout-btn" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-bold mt-6 transition-colors disabled:opacity-50" disabled>
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
    <button id="floating-cart-btn" class="floating-cart-btn lg:hidden text-white p-4 rounded-full">
        <i class="fas fa-shopping-cart text-xl"></i>
    </button>
    <div id="imagePopup" class="image-popup">
        <div class="image-popup-close">
            <i class="fas fa-times"></i>
        </div>
        <img src="" alt="Menu Image">
    </div>
    <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold mb-4">Complete Your Order</h2>
            <form id="checkoutForm" action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="items" id="cart_items">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">Your Email</label>
                    <input type="text" id="email" name="email" value="{{ session('email') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required readonly>
                </div>
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 mb-2">Your Name</label>
                    <input type="text" id="name" name="name" value="{{ session('name') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required readonly>
                </div>
                <div class="mb-4">
                    <label for="table_number" class="block text-gray-700 mb-2">Table Number</label>
                    <input type="text" id="table_number" name="table_number" value="{{ session('nomor_meja') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required readonly>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="resetEmailSession()"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        Reset Data
                    </button>
                    <button type="button" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400"
                        onclick="closeCheckoutModal()">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Place Order</button>
                </div>
            </form>
        </div>
    </div>
    <div id="resultModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold mb-4" id="resultModalTitle"></h2>
            <p id="resultModalMessage" class="mb-4"></p>
            <div class="flex justify-end">
                <button id="closeResultModalBtn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">OK</button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateCart();
        });

        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.getElementById('floating-cart-btn').addEventListener('click', function() {
            document.getElementById('order-summary').scrollIntoView({ behavior: 'smooth' });
        });

        const imagePopup = document.getElementById('imagePopup');
        const popupImage = imagePopup.querySelector('img');
        const popupClose = imagePopup.querySelector('.image-popup-close');

        document.querySelectorAll('.menu-image').forEach(img => {
            img.addEventListener('click', function() {
                popupImage.src = this.dataset.image;
                imagePopup.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        popupClose.addEventListener('click', function() {
            imagePopup.style.display = 'none';
            document.body.style.overflow = '';
        });

        imagePopup.addEventListener('click', function(e) {
            if (e.target === imagePopup) {
                imagePopup.style.display = 'none';
                document.body.style.overflow = '';
            }
        });

        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('bg-blue-500', 'text-white'));
                this.classList.add('bg-blue-500', 'text-white');
                const category = this.dataset.category;
                document.querySelectorAll('.food-card').forEach(card => {
                    card.style.display = category === 'all' || card.dataset.category === category ? 'block' : 'none';
                });
            });
        });

        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemId = this.dataset.id;
                const itemName = this.dataset.name;
                const itemPrice = parseFloat(this.dataset.price);
                const existingItem = cart.find(item => item.id === itemId);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: itemId,
                        name: itemName,
                        price: itemPrice,
                        quantity: 1
                    });
                }
                updateCart();
            });
        });

        function updateCart() {
            const orderItemsContainer = document.getElementById('order-items');
            const checkoutBtn = document.getElementById('checkout-btn');
            if (cart.length === 0) {
                orderItemsContainer.innerHTML = `
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-shopping-cart text-4xl mb-2 text-gray-300"></i>
                        <p>Your cart is empty</p>
                    </div>
                `;
                checkoutBtn.disabled = true;
            } else {
                orderItemsContainer.innerHTML = '';
                cart.forEach((item, index) => {
                    const itemEl = document.createElement('div');
                    itemEl.className = 'order-item flex items-center justify-between p-3 rounded-lg transition-colors';
                    itemEl.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div>
                                <h4 class="font-medium">${item.name}</h4>
                                <p class="text-sm text-gray-500">Rp ${item.price.toLocaleString()}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="quantity-btn text-gray-500 hover:text-blue-500 w-6 h-6 rounded-full flex items-center justify-center" data-index="${index}" data-action="decrease">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <span class="font-medium">${item.quantity}</span>
                            <button class="quantity-btn text-gray-500 hover:text-blue-500 w-6 h-6 rounded-full flex items-center justify-center" data-index="${index}" data-action="increase">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                            <button class="remove-btn text-red-500 hover:text-red-600 ml-2" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    orderItemsContainer.appendChild(itemEl);
                });
                checkoutBtn.disabled = false;
            }
            const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            const tax = subtotal * 0.1;
            const service = subtotal * 0.05;
            const total = subtotal + tax + service;
            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
            document.getElementById('tax').textContent = `Rp ${tax.toLocaleString()}`;
            document.getElementById('service').textContent = `Rp ${service.toLocaleString()}`;
            document.getElementById('total').textContent = `Rp ${total.toLocaleString()}`;
            const formattedItems = cart.map(item => ({
                id: item.id,
                quantity: item.quantity
            }));
            document.getElementById('cart_items').value = JSON.stringify(formattedItems);
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.quantity-btn')) {
                const btn = e.target.closest('.quantity-btn');
                const index = btn.dataset.index;
                const action = btn.dataset.action;
                if (action === 'increase') {
                    cart[index].quantity += 1;
                } else if (action === 'decrease') {
                    if (cart[index].quantity > 1) {
                        cart[index].quantity -= 1;
                    } else {
                        cart.splice(index, 1);
                    }
                }
                updateCart();
            }
            if (e.target.closest('.remove-btn')) {
                const index = e.target.closest('.remove-btn').dataset.index;
                cart.splice(index, 1);
                updateCart();
            }
        });

        document.getElementById('checkout-btn').addEventListener('click', function() {
            openCheckoutModal();
        });

        function openCheckoutModal() {
            document.getElementById('checkoutModal').classList.remove('hidden');
            document.getElementById('checkoutModal').classList.add('flex');
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.remove('flex');
            document.getElementById('checkoutModal').classList.add('hidden');
        }

        function resetEmailSession() {
            $.post("{{ route('reset.email.session') }}", {
                _token: '{{ csrf_token() }}'
            }, function(response) {
                window.location.href = response.redirect;
            });
        }

        $('#checkoutForm').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();
            Swal.fire({
                title: 'Memproses Pesanan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                success: function(response) {
                    cart = [];
                    localStorage.removeItem('cart');
                    updateCart();
                    closeCheckoutModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Berhasil!',
                        text: 'Pesanan Anda telah berhasil ditempatkan.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3b82f6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    closeCheckoutModal();
                    Swal.fire({
                        icon: 'error',
                        title: 'Pesanan Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3b82f6'
                    });
                }
            });
        });

        $('#closeResultModalBtn').click(function() {
            $('#resultModal').removeClass('flex').addClass('hidden');
        });
    </script>
</body>
</html>