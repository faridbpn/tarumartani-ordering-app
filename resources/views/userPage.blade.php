@extends('layouts.user')

@section('title', 'Menu')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Welcome to Tarumartani Cafe</h1>
            <p class="lead">Discover our delicious menu items</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('cart.show') }}" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> View Cart
                @if(session()->has('cart'))
                    <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Food Menu Section -->
    <h2 class="mb-4">Food Menu</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        @foreach($foods as $food)
        <div class="col">
            <div class="card h-100">
                @if($food->image)
                    <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top" alt="{{ $food->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-utensils fa-3x"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $food->name }}</h5>
                    <p class="card-text">{{ $food->description }}</p>
                    <p class="card-text"><strong>Rp {{ number_format($food->price, 0, ',', '.') }}</strong></p>
                    <form action="{{ route('cart.add', $food->id) }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                            <button class="btn btn-primary" type="submit">Add to Cart</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Beverage Menu Section -->
    <h2 class="mb-4">Beverage Menu</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($beverages as $beverage)
        <div class="col">
            <div class="card h-100">
                @if($beverage->image)
                    <img src="{{ asset('storage/' . $beverage->image) }}" class="card-img-top" alt="{{ $beverage->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-glass-martini-alt fa-3x"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $beverage->name }}</h5>
                    <p class="card-text">{{ $beverage->description }}</p>
                    <p class="card-text"><strong>Rp {{ number_format($beverage->price, 0, ',', '.') }}</strong></p>
                    <form action="{{ route('cart.add', $beverage->id) }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="number" name="quantity" class="form-control" value="1" min="1">
                            <button class="btn btn-primary" type="submit">Add to Cart</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection