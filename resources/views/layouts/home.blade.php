@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Catégories</h1>

        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4">
                    <div class="card">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/category-placeholder.jpg') }}" class="card-img-top" alt="{{ $category->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <a href="{{ route('category.products', $category->id) }}" class="btn btn-primary">Voir les produits</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
