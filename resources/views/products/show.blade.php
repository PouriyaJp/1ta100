<!-- resources/views/products/show.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p>{{ $product->price }}</p>
    <p>{{ $product->stock }}</p>

    <form action="{{ route('cart.add', $product) }}" method="POST">
        @csrf
        <div>
            <label>Quantity:</label>
            <input type="text" name="quantity">
        </div>
        <button type="submit">Add to Cart</button>
    </form>
@endsection
