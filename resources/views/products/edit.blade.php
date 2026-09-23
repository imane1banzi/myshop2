@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4" style="color: gray">Modifier le produit</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nom du produit</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image du produit — fond blanc, 800x800px, JPG/PNG &lt; 2Mo</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/webp">
            <div class="form-text">Laissez vide pour garder la photo actuelle. Pour remplacer : choisissez une photo fond blanc.</div>
            @if($product->image)
                <div class="bg-white border d-inline-block p-2 mt-2">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 200px; height: 200px; object-fit: contain;">
                </div>
            @endif
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
