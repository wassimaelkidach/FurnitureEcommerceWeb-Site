@extends('layouts.app')

@section('title', 'Nos Catégories')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Nos Catégories de Produits</h1>

    <div class="row g-4">
        @foreach($categories as $category)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100 border-0 shadow-hover">
                <div class="ratio ratio-4x3 bg-light">
                    @if($category->image && Storage::disk('public')->exists('categories/'.basename($category->image)))
                        <img src="{{ asset('storage/categories/' . basename($category->image)) }}" 
                             class="img-cover"
                             alt="{{ $category->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted">
                            <i class="fas fa-image fa-4x opacity-25"></i>
                        </div>
                    @endif
                </div>
                <div class="card-body text-center">
                    <h3 class="h5 card-title">{{ $category->name }}</h3>
                    <a href="{{ route('category.products', $category->id) }}" 
                       class="btn btn-primary stretched-link">
                       <i class="fas fa-arrow-right me-2"></i>Voir les produits
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .shadow-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .img-cover {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
</style>
@endsection