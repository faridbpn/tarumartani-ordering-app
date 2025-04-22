<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Food Ordering</title>
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
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="gradient-bg text-white p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-utensils text-2xl"></i>
                    <h1 class="text-xl font-bold">FoodExpress</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </button>
                    <button>
                        <i class="fas fa-user-circle text-xl"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 container mx-auto p-4 flex flex-col lg:flex-row gap-6">
            <!-- Menu Section -->
            <div class="lg:w-2/3">
                <!-- Category Tabs -->
                <div class="flex space-x-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
                    <button class="category-btn active px-4 py-2 rounded-full bg-blue-100 text-blue-600 font-medium whitespace-nowrap" data-category="all">
                        All Menu
                    </button>
                    <button class="category-btn px-4 py-2 rounded-full bg-gray-100 text-gray-600 font-medium whitespace-nowrap" data-category="food">
                        <i class="fas fa-hamburger mr-2"></i>Food
                    </button>
                    <button class="category-btn px-4 py-2 rounded-full bg-gray-100 text-gray-600 font-medium whitespace-nowrap" data-category="drink">
                        <i class="fas fa-coffee mr-2"></i>Drinks
                    </button>
                    <button class="category-btn px-4 py-2 rounded-full bg-gray-100 text-gray-600 font-medium whitespace-nowrap" data-category="dessert">
                        <i class="fas fa-ice-cream mr-2"></i>Desserts
                    </button>
                </div>

                <!-- Menu Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Food Item 1 -->
                    <div class="food-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300" data-category="food">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Burger" class="w-full h-40 object-cover">
                            <span class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">Popular</span>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg">Classic Burger</h3>
                                <span class="text-blue-600 font-bold">$8.99</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Beef patty with cheese, lettuce and special sauce</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-600 text-sm">4.8 (120)</span>
                                </div>
                                <button class="add-to-cart bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition-colors" 
                                        data-name="Classic Burger" 
                                        data-price="8.99" 
                                        data-img="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Food Item 2 -->
                    <div class="food-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300" data-category="food">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Salad" class="w-full h-40 object-cover">
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg">Fresh Salad</h3>
                                <span class="text-blue-600 font-bold">$6.99</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Mixed greens with cherry tomatoes and balsamic dressing</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-600 text-sm">4.5 (85)</span>
                                </div>
                                <button class="add-to-cart bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition-colors"
                                        data-name="Fresh Salad" 
                                        data-price="6.99" 
                                        data-img="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Drink Item 1 -->
                    <div class="food-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300" data-category="drink">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1513558161293-cdaf765ed2a1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Coffee" class="w-full h-40 object-cover">
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg">Iced Coffee</h3>
                                <span class="text-blue-600 font-bold">$3.99</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Cold brew coffee with milk and ice</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-600 text-sm">4.7 (150)</span>
                                </div>
                                <button class="add-to-cart bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition-colors"
                                        data-name="Iced Coffee" 
                                        data-price="3.99" 
                                        data-img="https://images.unsplash.com/photo-1513558161293-cdaf765ed2a1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Food Item 3 -->
                    <div class="food-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300" data-category="food">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1561758033-d89a9ad46330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Pizza" class="w-full h-40 object-cover">
                            <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg">Margherita Pizza</h3>
                                <span class="text-blue-600 font-bold">$12.99</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Classic pizza with tomato sauce, mozzarella and basil</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-600 text-sm">4.9 (200)</span>
                                </div>
                                <button class="add-to-cart bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition-colors"
                                        data-name="Margherita Pizza" 
                                        data-price="12.99" 
                                        data-img="https://images.unsplash.com/photo-1561758033-d89a9ad46330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Drink Item 2 -->
                    <div class="food-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300" data-category="drink">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1551029506-0807df4e2031?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Smoothie" class="w-full h-40 object-cover">
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg">Berry Smoothie</h3>
                                <span class="text-blue-600 font-bold">$5.99</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Mixed berries with yogurt and honey</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-600 text-sm">4.6 (90)</span>
                                </div>
                                <button class="add-to-cart bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition-colors"
                                        data-name="Berry Smoothie" 
                                        data-price="5.99" 
                                        data-img="https://images.unsplash.com/photo-1551029506-0807df4e2031?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Dessert Item 1 -->
                    <div class="food-card bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300" data-category="dessert">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="Ice Cream" class="w-full h-40 object-cover">
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg">Chocolate Ice Cream</h3>
                                <span class="text-blue-600 font-bold">$4.99</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Rich chocolate ice cream with chocolate chips</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-600 text-sm">4.8 (110)</span>
                                </div>
                                <button class="add-to-cart bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-sm transition-colors"
                                        data-name="Chocolate Ice Cream" 
                                        data-price="4.99" 
                                        data-img="https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Your Order</h2>
                    
                    <div id="order-items" class="mb-4 max-h-96 overflow-y-auto">
                        <!-- Order items will be added here -->
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-shopping-cart text-4xl mb-2 text-gray-300"></i>
                            <p>Your cart is empty</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span id="subtotal" class="font-medium">$0.00</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Tax (10%):</span>
                            <span id="tax" class="font-medium">$0.00</span>
                        </div>
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Delivery Fee:</span>
                            <span id="delivery" class="font-medium">$2.50</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-3">
                            <span>Total:</span>
                            <span id="total" class="text-blue-600">$2.50</span>
                        </div>
                    </div>
                    
                    <button id="checkout-btn" class="gradient-bg hover:opacity-90 text-white w-full py-3 rounded-lg font-bold mt-6 transition-opacity disabled:opacity-50" disabled>
                        Checkout
                    </button>
                    
                    <div class="mt-4 text-center text-sm text-gray-500">
                        <p>By placing your order, you agree to our <a href="#" class="text-blue-500">Terms of Service</a></p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cart state
            let cart = [];
            
            // DOM elements
            const categoryBtns = document.querySelectorAll('.category-btn');
            const foodCards = document.querySelectorAll('.food-card');
            const addToCartBtns = document.querySelectorAll('.add-to-cart');
            const orderItemsContainer = document.getElementById('order-items');
            const cartCount = document.getElementById('cart-count');
            const subtotalEl = document.getElementById('subtotal');
            const taxEl = document.getElementById('tax');
            const deliveryEl = document.getElementById('delivery');
            const totalEl = document.getElementById('total');
            const checkoutBtn = document.getElementById('checkout-btn');
            
            // Category filter
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const category = this.dataset.category;
                    
                    // Update active button
                    categoryBtns.forEach(b => b.classList.remove('active', 'bg-blue-500', 'text-white'));
                    this.classList.add('active', 'bg-blue-500', 'text-white');
                    this.classList.remove('bg-gray-100', 'text-gray-600');
                    
                    // Filter items
                    foodCards.forEach(card => {
                        if (category === 'all' || card.dataset.category === category) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
            
            // Add to cart functionality
            addToCartBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const name = this.dataset.name;
                    const price = parseFloat(this.dataset.price);
                    const img = this.dataset.img;
                    
                    // Check if item already in cart
                    const existingItem = cart.find(item => item.name === name);
                    
                    if (existingItem) {
                        existingItem.quantity += 1;
                    } else {
                        cart.push({
                            name,
                            price,
                            img,
                            quantity: 1
                        });
                    }
                    
                    updateCart();
                });
            });
            
            // Update cart UI
            function updateCart() {
                // Update cart count
                const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
                cartCount.textContent = itemCount;
                
                // Update order items
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
                                <img src="${item.img}" alt="${item.name}" class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <h4 class="font-medium">${item.name}</h4>
                                    <p class="text-sm text-gray-500">$${item.price.toFixed(2)}</p>
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
                const delivery = 2.5;
                const total = subtotal + tax + delivery;
                
                subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
                taxEl.textContent = `$${tax.toFixed(2)}`;
                deliveryEl.textContent = `$${delivery.toFixed(2)}`;
                totalEl.textContent = `$${total.toFixed(2)}`;
            }
            
            // Handle quantity changes and item removal
            orderItemsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.quantity-btn')) {
                    const btn = e.target.closest('.quantity-btn');
                    const index = parseInt(btn.dataset.index);
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
                    const btn = e.target.closest('.remove-btn');
                    const index = parseInt(btn.dataset.index);
                    
                    cart.splice(index, 1);
                    updateCart();
                }
            });
            
            // Checkout button
            checkoutBtn.addEventListener('click', function() {
                alert('Order placed successfully! Thank you for your purchase.');
                cart = [];
                updateCart();
            });
        });
    </script>
</body>
</html>