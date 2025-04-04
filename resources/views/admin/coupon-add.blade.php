@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="wg-box">
        <form class="form-new-product-form-style-1" method="POST" action="{{ route('admin.coupon.store') }}">
            @csrf
            
            <!-- Coupon Code Field -->
            <fieldset class="name">
                <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                <input class="flex-grow @error('code') is-invalid @enderror" 
                       type="text" 
                       placeholder="Coupon Code" 
                       name="code"
                       value="{{ old('code') }}" 
                       required>
            </fieldset>
            @error('code')
                <span class="alert alert-danger text-danger">{{ $message }}</span>
            @enderror

            <!-- Coupon Type Field -->
            <fieldset class="category">
                <div class="body-title">Coupon Type <span class="tf-color-1">*</span></div>
                <div class="select flex-grow">
                    <select class="@error('type') is-invalid @enderror" name="type" required>
                        <option value="">Select</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percent</option>
                    </select>
                </div>
            </fieldset>
            @error('type')
                <span class="alert alert-danger text-danger">{{ $message }}</span>
            @enderror

            <!-- Value Field -->
            <fieldset class="name">
                <div class="body-title">Value <span class="tf-color-1">*</span></div>
                <input class="flex-grow @error('value') is-invalid @enderror" 
                       type="number" 
                       placeholder="Coupon Value" 
                       name="value"
                       step="{{ old('type') == 'percent' ? '0.01' : '1' }}"
                       value="{{ old('value') }}" 
                       required>
            </fieldset>
            @error('value')
                <span class="alert alert-danger text-danger">{{ $message }}</span>
            @enderror

            <!-- Cart Value Field -->
            <fieldset class="name">
                <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                <input class="flex-grow @error('cart_value') is-invalid @enderror" 
                       type="number" 
                       placeholder="Cart Value"
                       name="cart_value" 
                       min="0"
                       value="{{ old('cart_value') }}" 
                       required>
            </fieldset>
            @error('cart_value')
                <span class="alert alert-danger text-danger">{{ $message }}</span>
            @enderror

            <!-- Expiry Date Field -->
            <fieldset class="name">
                <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                <input class="flex-grow @error('expiry_date') is-invalid @enderror" 
                       type="date" 
                       placeholder="Expiry Date"
                       name="expiry_date" 
                       min="{{ date('Y-m-d') }}"
                       value="{{ old('expiry_date') }}" 
                       required>
            </fieldset>
            @error('expiry_date')
                <span class="alert alert-danger text-danger">{{ $message }}</span>
            @enderror

            <!-- Submit Button -->
            <div class="bot">
                <a href="{{ route('admin.coupons') }}" class="btn btn-secondary">Cancel</a>
                <button class="tf-button w208" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success mt-3">
        {{ session('status') }}
    </div>
@endif

@endsection