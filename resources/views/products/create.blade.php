<!-- resources/views/products/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create Product</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div>
            <label>Name:</label>
            <input type="text" name="name">
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Price:</label>
            <input type="text" name="price">
        </div>
        <div>
            <label>Stock:</label>
            <input type="text" name="stock">
        </div>
        <button type="submit">Create</button>
    </form>
@endsection
