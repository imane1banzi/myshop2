@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5" style="color: gray;">Ajouter un produit</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="w-75 mx-auto">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom du produit</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image du produit</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
        </div>
    </form>
</div>
@endsection
