<!-- resources/views/cart/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Cart</h1>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <ul>
        @forelse ($cart->items as $item)
            <li>
                {{ $item->product->name }} ({{ $item->quantity }})
                <form action="{{ route('cart.remove', $item->product) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                    <button type="submit">Remove</button>
                </form>
            </li>
        @empty
            <p>No items in cart</p>
        @endforelse
    </ul>
@endsection
