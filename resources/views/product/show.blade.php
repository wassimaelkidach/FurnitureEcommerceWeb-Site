@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tous les Produits</h1>

    <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1100"></div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <!-- Image du produit -->
                @if($product->image)
                    <img src="{{ $product->image }}" class="card-img-top" 
                         alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" 
                         style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                    <p class="mt-auto fw-bold">{{ number_format($product->price, 2) }} €</p>
                    
                    <form class="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="color" class="form-select" required>
                                <option value="">Select Color</option>
                                @if(is_array($product->colors) || is_object($product->colors))
                                    @foreach($product->colors as $key => $value)
                                        <option value="{{ is_array($value) ? ($value['name'] ?? $key) : $value }}">
                                            {{ is_array($value) ? ($value['name'] ?? $key) : $value }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <input type="number" name="quantity" value="1" min="1" 
                                   max="{{ $product->stock }}" class="form-control" required>
                            <button type="submit" class="btn btn-success add-to-cart-btn">
                                <span class="btn-text">Ajouter</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alertContainer = document.getElementById('alert-container');
    
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.add-to-cart-btn');
            const spinner = button.querySelector('.spinner-border');
            const btnText = button.querySelector('.btn-text');
            
            // Show loading state
            btnText.textContent = 'Ajout...';
            spinner.classList.remove('d-none');
            button.disabled = true;
            
            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (!response.ok) throw new Error(data.message || 'Erreur serveur');
                
                // Show success alert
                showAlert('success', data.message || 'Produit ajouté au panier');
                
                // Update cart count if needed
                if (typeof updateCartCount === 'function') {
                    updateCartCount(data.cart_count);
                }
                
            } catch (error) {
                showAlert('danger', error.message || 'Erreur lors de l\'ajout au panier');
            } finally {
                // Reset button state
                btnText.textContent = 'Ajouter';
                spinner.classList.add('d-none');
                button.disabled = false;
            }
        });
    });
    
    function showAlert(type, message) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.role = 'alert';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }, 3000);
    }
});
</script>

<style>
    .add-to-cart-btn {
        position: relative;
        min-width: 100px;
    }
    .spinner-border {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
@endsection