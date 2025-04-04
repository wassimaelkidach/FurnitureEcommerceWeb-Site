@extends('layouts.app')

@section('content')
<style>
  /* Checkout Page Styles */
main.pt-90 {
    padding-top: 90px;
}

.shop-checkout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.page-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 30px;
    color: #333;
}

/* Checkout Steps */
.checkout-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 40px;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

.checkout-steps__item {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #999;
    position: relative;
    padding-bottom: 15px;
}

.checkout-steps__item.active {
    color: #333;
    font-weight: 500;
}

.checkout-steps__item.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: #3a86ff;
}

.checkout-steps__item-number {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #f5f5f5;
    margin-right: 10px;
    font-size: 14px;
}

.checkout-steps__item.active .checkout-steps__item-number {
    background-color: #3a86ff;
    color: white;
}

.checkout-steps__item-title {
    display: flex;
    flex-direction: column;
}

.checkout-steps__item-title em {
    font-style: normal;
    font-size: 12px;
    color: #999;
}

.checkout-steps__item.active .checkout-steps__item-title em {
    color: #666;
}

/* Billing Info */
.billing-info__wrapper h4 {
    font-size: 18px;
    margin-bottom: 20px;
    color: #333;
    font-weight: 600;
}

.form-floating {
    position: relative;
    margin-bottom: 1rem;
}

.form-control {
    height: 50px;
    border-radius: 4px;
    border: 1px solid #ddd;
    padding: 10px 15px;
    font-size: 14px;
}

.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(58, 134, 255, 0.25);
    border-color: #3a86ff;
}

label {
    font-size: 14px;
    color: #666;
}

.text-danger {
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

/* Address Display */
.my-account_address-list-item {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.my-account_address-item_detail p {
    margin: 5px 0;
    color: #555;
}

/* Order Summary */
.checkout__totals-wrapper {
    background: #f9f9f9;
    padding: 25px;
    border-radius: 5px;
}

.sticky-content {
    position: sticky;
    top: 100px;
}

.checkout__totals h3 {
    font-size: 20px;
    margin-bottom: 20px;
    color: #333;
    font-weight: 600;
}

table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
}

.checkout-cart-items th, 
.checkout-totals th {
    text-align: left;
    padding: 10px 0;
    font-weight: 500;
    color: #555;
}

.checkout-cart-items td, 
.checkout-totals td {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    color: #333;
}

.checkout-totals tr:last-child th,
.checkout-totals tr:last-child td {
    border-bottom: none;
    font-weight: 600;
    color: #333;
}

/* Payment Methods */
.checkout__payment-methods {
    margin: 30px 0;
}

.form-check {
    margin-bottom: 20px;
}

.form-check-input {
    margin-right: 10px;
}

.form-check-label {
    display: block;
    font-weight: 500;
    color: #333;
}

.option-detail {
    font-size: 13px;
    color: #666;
    margin: 5px 0 0 25px;
    font-weight: normal;
}

.policy-text {
    font-size: 12px;
    color: #999;
    margin: 20px 0;
    line-height: 1.5;
}

.policy-text a {
    color: #3a86ff;
    text-decoration: none;
}

/* Checkout Button */
.btn-checkout {
    width: 100%;
    padding: 15px;
    font-size: 16px;
    font-weight: 600;
    background-color: #3a86ff;
    border: none;
    border-radius: 4px;
    transition: all 0.3s;
}

.btn-checkout:hover {
    background-color: #2667cc;
}

/* Responsive */
@media (max-width: 768px) {
    .checkout-steps {
        flex-direction: column;
    }
    
    .checkout-steps__item {
        margin-bottom: 15px;
    }
    
    .checkout-form {
        flex-direction: column;
    }
    
    .billing-info__wrapper, 
    .checkout__totals-wrapper {
        width: 100%;
    }
    
    .checkout__totals-wrapper {
        margin-top: 30px;
    }
}
/* Shipping Details Two-Column Layout */
.shipping-details-form {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.shipping-details-form h4 {
    grid-column: 1 / -1;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #2c3e50;
    text-transform: uppercase;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: #555;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: all 0.3s;
}

.form-group input:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
}

/* Make full-width on mobile */
@media (max-width: 768px) {
    .shipping-details-form {
        grid-template-columns: 1fr;
    }
}
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Shipping and Checkout</h2>
      <div class="checkout-steps">
        <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <form name="checkout-form" action="">
        <div class="checkout-form">
          <div class="billing-info__wrapper">
            <div class="row">
              <div class="col-6">
                <h4>SHIPPING DETAILS</h4>
              </div>
              <div class="col-6">
              </div>
            </div>
            
            @if($address)
    <div class="row">
        <div class="col-md-12">
            <div class="my-account_address-list">
                <div class="my-account_address-list-item">
                    <div class="my-account_address-item_detail">
                        <p>{{ $address->name }}</p>
                        <p>{{ $address->address }}</p>
                        @if($address->landmark)
                            <p>{{ $address->landmark }}</p>
                        @endif
                        <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                        <p>{{ $address->zip }}</p>
                        <br/>
                        <p>{{ $address->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="name" required="" value="{{ old('name') }}">
                  <label for="name">Full Name *</label>
                  @error('name') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="phone" required="" value="{{ old('phone') }}">
                  <label for="phone">Phone Number *</label>
                  @error('phone') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="zip" required="" value="{{ old('zip') }}">
                  <label for="zip">Pincode *</label>
                  @error('zip') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating mt-3 mb-3">
                  <input type="text" class="form-control" name="state" required="" value="{{ old('state') }}">
                  <label for="state">State *</label>
                  @error('state') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="city" required="" value="{{ old('city') }}">
                  <label for="city">Town / City *</label>
                  @error('city') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="address" required="" value="{{ old('address') }}">
                  <label for="address">House no, Building Name *</label>
                  @error('address') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="locality" required="" value="{{ old('locality') }}">
                  <label for="locality">Road Name, Area, Colony *</label>
                  @error('locality') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="landmark" required="" value="{{ old('landmark') }}">
                  <label for="landmark">Landmark *</label>
                  @error('landmark') <span class="text-danger">{{  $message}}</span>@enderror
                </div>
              </div>
            </div>
            @endif
          </div>
          
          <div class="checkout__totals-wrapper">
            <div class="sticky-content">
              <div class="checkout__totals">
                <h3>Your Order</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>PRODUCT</th>
                      <th align="right">SUBTOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach(Cart::instance('cart')->content() as $item)
                  <tr>
    <td>
    {{$item->name}} x {{$item->qty}}
</td>
    <td align="right">
    ${{$item->subtotal()}}
</td>
</tr>
@endforeach
                  
                  </tbody>
                </table>
                @if(Session::has('discounts') )
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
                @else
                <table class="checkout-totals">
    <tbody>
        <tr>
            <th>SUBTOTAL</th>
            <td align="right">${{ Cart::instance('cart')->subtotal() }}</td>
        </tr>
        <tr>
            <th>SHIPPING</th>
            <td align="right">Free shipping</td>
        </tr>
        <tr>
            <th>VAT</th>
            <td align="right">${{ Cart::instance('cart')->tax() }}</td>
        </tr>
        <tr>
            <th>TOTAL</th>
            <td align="right">${{ Cart::instance('cart')->total() }}</td>
        </tr>
    </tbody>
</table>
@endif
              </div>
              <div class="checkout__payment-methods">
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                    id="checkout_payment_method_1" checked>
                  <label class="form-check-label" for="checkout_payment_method_1">
                    Direct bank transfer
                    <p class="option-detail">
                      Make your payment directly into our bank account. Please use your Order ID as the payment
                      reference.Your order will not be shipped until the funds have cleared in our account.
                    </p>
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                    id="checkout_payment_method_2">
                  <label class="form-check-label" for="checkout_payment_method_2">
                    Check payments
                    <p class="option-detail">
                      Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                      aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                      magna posuere eget.
                    </p>
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                    id="checkout_payment_method_3">
                  <label class="form-check-label" for="checkout_payment_method_3">
                    Cash on delivery
                    <p class="option-detail">
                      Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                      aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                      magna posuere eget.
                    </p>
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                    id="checkout_payment_method_4">
                  <label class="form-check-label" for="checkout_payment_method_4">
                    Paypal
                    <p class="option-detail">
                      Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                      aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                      magna posuere eget.
                    </p>
                  </label>
                </div>
                <div class="policy-text">
                  Your personal data will be used to process your order, support your experience throughout this
                  website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                    policy</a>.
                </div>
              </div>
              <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
            </div>
          </div>
        </div>
      </form>
    </section>
</main>
@endsection