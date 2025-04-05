document.addEventListener('DOMContentLoaded', function() {
    // Quantity update handlers
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const input = this.parentElement.querySelector('.quantity-input');
            let quantity = parseInt(input.value);
            
            if (this.classList.contains('minus') && quantity > 1) {
                quantity--;
            } else if (this.classList.contains('plus')) {
                quantity++;
            }
            
            input.value = quantity;
            // You would typically trigger an AJAX call here to update the cart
        });
    });
    
    // Coupon application feedback
    const couponForm = document.querySelector('#coupon-form');
    if (couponForm) {
        couponForm.addEventListener('submit', function(e) {
            const couponInput = this.querySelector('input[name="coupon_code"]');
            if (!couponInput.value.trim()) {
                e.preventDefault();
                alert('Please enter a coupon code');
            }
        });
    }
});