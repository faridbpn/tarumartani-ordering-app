<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Categories -->
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
            <!-- Menu Items -->
            <div class="lg:w-2/3">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($menuItems as $item)
                        @if($item->is_available)
                        <div class="food-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300" data-category="{{ $item->category_id }}">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/300x200' }}" 
                                alt="{{ $item->name }}" 
                                class="w-full h-48 object-cover">
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

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
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

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h2 class="text-2xl font-bold mb-4">Complete Your Order</h2>
            <form id="checkoutForm" action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="cart_items" id="cart_items">
                <div class="mb-4">
                    <label for="customer_name" class="block text-gray-700 mb-2">Your Name</label>
                    <input type="text" id="customer_name" name="customer_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="table_number" class="block text-gray-700 mb-2">Table Number</label>
                    <input type="text" id="table_number" name="table_number" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400" onclick="closeCheckoutModal()">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Place Order</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success/Failure Modal -->
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
        let cart = [];

        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Category filtering
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

        // Add to cart functionality
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

        // Update cart UI
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

            // Calculate totals
            const subtotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            const tax = subtotal * 0.1;
            const service = subtotal * 0.05;
            const total = subtotal + tax + service;

            document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
            document.getElementById('tax').textContent = `Rp ${tax.toLocaleString()}`;
            document.getElementById('service').textContent = `Rp ${service.toLocaleString()}`;
            document.getElementById('total').textContent = `Rp ${total.toLocaleString()}`;

            // Update cart items for checkout
            document.getElementById('cart_items').value = JSON.stringify(cart);
        }

        // Handle quantity changes and item removal
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

        // Checkout button
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

        // Handle form submission
        $('#checkoutForm').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();
            const url = form.attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                success: function(response) {
                    closeCheckoutModal();
                    $('#resultModalTitle').text('Pesanan Berhasil!');
                    $('#resultModalMessage').text('Pesanan Anda telah berhasil ditempatkan.');
                    $('#resultModal').removeClass('hidden').addClass('flex');
                },
                error: function(xhr) {
                    console.log('Error Status:', xhr.status);
                    console.log('Error Response:', xhr.responseText);
                    closeCheckoutModal();
                    $('#resultModalTitle').text('Pesanan Gagal!');
                    $('#resultModalMessage').text('Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.');
                    $('#resultModal').removeClass('hidden').addClass('flex');
                }
            });
        });

        // Close result modal
        $('#closeResultModalBtn').click(function() {
            $('#resultModal').removeClass('flex').addClass('hidden');
        });
    </script>
</body>
</html>