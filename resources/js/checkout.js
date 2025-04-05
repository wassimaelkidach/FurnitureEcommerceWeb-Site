document.addEventListener('DOMContentLoaded', function() {
    // Show/hide credit card form
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            const creditCardForm = document.getElementById('credit-card-form');
            if (this.id === 'payment_credit') {
                creditCardForm.style.display = 'block';
            } else {
                creditCardForm.style.display = 'none';
            }
            
            // Enable/disable Klarna options
            if (this.id === 'payment_klarna') {
                document.querySelectorAll('input[name="klarna_option"]').forEach(opt => {
                    opt.disabled = false;
                });
            } else {
                document.querySelectorAll('input[name="klarna_option"]').forEach(opt => {
                    opt.disabled = true;
                });
            }
        });
    });

    // Save address button
    document.getElementById('save-address-btn').addEventListener('click', function() {
        const formData = new FormData(document.querySelector('form'));
        
        fetch('/addresses', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Address saved successfully!');
            } else {
                alert('Error saving address: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving the address');
        });
    });
});