@extends('layouts.app')

@section('content')
<style>
/* Main Layout */
.pt-90 {
    padding-top: 90px;
}

.shop-checkout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Checkout Steps */
.checkout-steps {
    display: flex;
    justify-content: space-between;
    margin: 30px 0 40px;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
}

.checkout-steps__item {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #777;
    position: relative;
    padding-bottom: 15px;
}

.checkout-steps__item.active {
    color: #000;
    font-weight: 500;
}

.checkout-steps__item.active:after {
    content: '';
    position: absolute;
    bottom: -16px;
    left: 0;
    width: 100%;
    height: 3px;
    background: #000;
}

.checkout-steps__item-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    background: #eee;
    border-radius: 50%;
    margin-right: 10px;
    font-size: 12px;
}

.checkout-steps__item.active .checkout-steps__item-number {
    background: #000;
    color: #fff;
}

.checkout-steps__item-title {
    display: flex;
    flex-direction: column;
}

.checkout-steps__item-title em {
    font-style: normal;
    font-size: 12px;
    color: #999;
    margin-top: 3px;
}

/* Cart Table */
.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

.cart-table th {
    text-align: left;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
    font-weight: 500;
    color: #333;
}

.cart-table td {
    padding: 20px 0;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.shopping-cart_product-item img {
    border-radius: 4px;
    object-fit: cover;
}

.shopping-cart_product-item_detail h4 {
    margin: 0 0 5px;
    font-size: 16px;
    font-weight: 500;
}

.shopping-cart_product-item_options {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 13px;
    color: #777;
}

.shopping-cart_product-price,
.shopping-cart_subtotal {
    font-weight: 500;
    color: #333;
}

/* Quantity Control */
.qty-control {
    display: flex;
    align-items: center;
}
.qty-btn {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
.qty-input {
    -moz-appearance: textfield;
}
.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.remove-cart {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    transition: all 0.3s;
}

.remove-cart:hover {
    background: #f8f8f8;
}

/* Cart Footer */
.cart-table-footer {
    display: flex;
    justify-content: space-between;
    margin: 30px 0;
}

.cart-table-footer form {
    position: relative;
    width: 300px;
}

.cart-table-footer input[type="text"] {
    width: 100%;
    padding: 12px 100px 12px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.cart-table-footer input[type="submit"] {
    background: none;
    border: none;
    color: #333;
    font-weight: 500;
    cursor: pointer;
}

.cart-table-footer input[type="submit"]:hover {
    color: #000;
}

.btn-light {
    background: #f8f8f8;
    border: 1px solid #ddd;
    padding: 12px 25px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-light:hover {
    background: #eee;
}

/* Cart Totals */
.shopping-cart__totals-wrapper {
    margin-top: 40px;
}

.shopping-cart__totals {
    background: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
}

.shopping-cart__totals h3 {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 20px;
}

.cart-totals {
    width: 100%;
}

.cart-totals th,
.cart-totals td {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.cart-totals tr:last-child th,
.cart-totals tr:last-child td {
    border-bottom: none;
    font-weight: 500;
    font-size: 18px;
}

/* Empty Cart */
.text-center.pt-5.pb-5 {
    padding: 50px 0;
}

.text-center.pt-5.pb-5 p {
    margin-bottom: 20px;
    font-size: 18px;
    color: #777;
}

/* Responsive */
@media (max-width: 768px) {
    .cart-table th:nth-child(3),
    .cart-table td:nth-child(3),
    .cart-table th:nth-child(5),
    .cart-table td:nth-child(5) {
        display: none;
    }
    
    .cart-table-footer {
        flex-direction: column;
    }
    
    .cart-table-footer form {
        width: 100%;
        margin-bottom: 15px;
    }
}
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Cart</h2>
        <div class="checkout-steps">
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>
        <div class="shopping-cart">
            @if($items->count()>0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th></th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <div class="shopping-cart_product-item">
                                            <img loading="lazy" src="{{ asset('storage/' . $item->model->image) }}" width="120" height="120" alt="{{ $item->name }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="shopping-cart_product-item_detail">
                                            <h4>{{ $item->name }}</h4>
                                            <ul class="shopping-cart_product-item_options">
                                                <li>Color: Yellow</li>
                                                <li>Size: L</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="shopping-cart_product-price">${{ $item->price }}</span>
                                    </td>
                                    <td>
                                        <div class="qty-control d-flex align-items-center">
                                            <form method="POST" action="{{ route('cart.qty.decrease', $item->rowId) }}" class="me-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-outline-secondary qty-btn">-</button>
                                            </form>
                                            <input type="number" 
                                                   value="{{ $item->qty }}" 
                                                   min="1" 
                                                   class="form-control text-center qty-input"
                                                   style="width: 60px"
                                                   readonly>
                                            <form method="POST" action="{{ route('cart.qty.increase', $item->rowId) }}" class="ms-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-outline-secondary qty-btn">+</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="shopping-cart_subtotal">${{ $item->subtotal()}}</span>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.remove', $item->rowId) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="remove-cart bg-transparent border-0 p-0">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="cart-table-footer">
                        <form action="{{ route('cart.coupon.apply') }}" method="POST" class="position-relative bg-body">
                            @csrf
                            <input class="form-control" 
                                   type="text" 
                                   name="coupon_code" 
                                   placeholder="Coupon code" 
                                   value="@if(Session::has('coupon')) {{ Session::get('coupon')['code'] }} @endif">
                            <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" 
                                   type="submit" 
                                   value="APPLY COUPON">
                        </form>
                        <form action="{{ route('cart.empty') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-light" type="submit">CLEAR CART</button>
                        </form>
                    </div>
                </div>

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="shopping-cart__totals-wrapper">
                    <div class="sticky-content">
                        <div class="shopping-cart__totals">
                        <h3>Cart Totals</h3>
@if(Session::has('discounts'))
<table class="cart-totals">
    <tbody>
        <tr>
            <th>Subtotal</th>
            <td>${{ Cart::instance('cart')->subtotal() }}</td>
        </tr>
        <tr>
            <th>Discount ({{ Session::get('coupon')['code'] }})</th>
            <td>${{ Session::get('discounts')['discount'] }}</td>
        </tr>
        <tr>
            <th>Subtotal After Discount</th>
            <td>${{ Session::get('discounts')['subtotal_after_discount'] }}</td>
        </tr>
        <tr>
            <th>Shipping</th>
            <td>Free</td>
        </tr>
        <tr>
            <th>VAT</th>
            <td>${{ Session::get('discounts')['tax'] }}</td>
        </tr>
        <tr>
            <th>Totals</th>
            <td>${{ Session::get('discounts')['total'] }}</td>
        </tr>
    </tbody>
</table>
                            @else
                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>${{ Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td>Free</td>
                                        </tr>
                                        <tr>
                                            <th>VAT</th>
                                            <td>${{ Cart::instance('cart')->tax() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td>${{ Cart::instance('cart')->total()}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="mobile_fixed-btn_wrapper">
    <div class="button-wrapper container">
        @if(Cart::instance('cart')->count() > 0)
            <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-checkout">
                PROCEED TO CHECKOUT
            </a>
        @else
            <button class="btn btn-primary btn-checkout" disabled>
                PROCEED TO CHECKOUT
            </button>
        @endif
    </div>
</div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center pt-5 pb-5">
                        <p>No items found in your cart</p>
                        <a href="" class="btn btn-info">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
  @endsection
  @push('scripts')
<script>
$(document).ready(function() {
    $('.qty-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                location.reload(); // Rafraîchir après modification
            },
            error: function() {
                alert('Erreur lors de la mise à jour');
            }
        });
    });
});
$('.btn-remove').click(function(e) {
    e.preventDefault();
    let form = $(this).closest('form');
    
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            // Update cart UI
            $('.cart-count').text(response.cart_count);
            $('.cart-total').text('$'+response.cart_total);
            form.closest('tr').remove();
            
            // Show success message
            alert('Item removed successfully');
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseJSON.error);
        }
    });
});

</script>
@endpush