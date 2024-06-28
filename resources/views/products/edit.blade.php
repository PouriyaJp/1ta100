<!-- resources/views/products/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="{{ $product->name }}">
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description">{{ $product->description }}</textarea>
        </div>
        <div>
            <label>Price:</label>
            <input type="text" name="price" value="{{ $product->price }}">
        </div>
        <div>
            <label>Stock:</label>
            <input type="text" name="stock" value="{{ $product->stock }}">
        </div>
        <button type="submit">Update</button>
    </form>
@endsection
