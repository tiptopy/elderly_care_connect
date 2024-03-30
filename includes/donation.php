<script src="https://js.paystack.co/v1/inline.js"></script>

<?php
include 'configs.php'; // Include configuration file

$currency = "KES"; // Define currency
?>

<script type="text/javascript">
    const paymentForm = document.getElementById('paymentForm'); // Get payment form element
    paymentForm.addEventListener("submit", payWithPaystack, false); // Add event listener for form submission
    var Path = getPath(); // Get the relative path

    function payWithPaystack(e) {
        // Retrieve form values and store in sessionStorage
        let donorName = document.getElementById('donorName').value;
        sessionStorage.setItem('donorName', donorName);

        let donorPhone = document.getElementById('donorPhone').value;
        sessionStorage.setItem('donorPhone', donorPhone);

        let donorAmount = document.getElementById('donorAmount').value;
        sessionStorage.setItem('donorAmount', donorAmount);

        let creator_phone_number = document.getElementById('creator_phone_number').value;
        sessionStorage.setItem('creator_phone_number', creator_phone_number);

        let formData = new FormData(paymentForm); // Create FormData object from form
        formData.append('donorName', donorName);
        formData.append('donorPhone', donorPhone);
        formData.append('donorAmount', donorAmount);
        formData.append('creator_phone_number', creator_phone_number);
        
        e.preventDefault(); // Prevent default form submission

        let handler = PaystackPop.setup({
            key: '<?php echo $PublicKey; ?>', // Set Paystack public key
            email: document.getElementById('donorEmail').value, // Get email from form
            amount: document.getElementById('donorAmount').value * 100, // Convert amount to kobo
            currency: '<?php echo $currency; ?>', // Set currency
            ref: '' + Math.floor((Math.random() * 1000000000) + 1), // Generate random reference
            onClose: function() {
                alert('Transaction was not completed, window closed.'); // Alert if transaction window closed
            },
            callback: function(response) {
                let message = 'Payment complete! Reference: ' + response.reference;
                
                // Send SMS message
                fetch(Path + 'includes/sms_message.php', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    // Handle response if needed
                }).catch(error => {
                    // Handle error if needed
                });

                // Send WhatsApp message
                fetch(Path + 'includes/WhatsappMessage.php', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    // Handle response if needed
                }).catch(error => {
                    // Handle error if needed
                });

                alert(message); // Alert payment completion message
                window.location.href = Path + "includes/verify_transaction.php?reference=" + response.reference; // Redirect to transaction verification
            }
        });

        handler.openIframe(); // Open Paystack payment iframe
    }

    function getPath() {
        // Get the current path
        var currentPath = window.location.pathname;

        // Check if the current path is in the root directory
        if (currentPath === '/') {
            return './';
        } else {
            // If the current path is inside a folder, construct the correct path
            var pathSegments = currentPath.split('/');
            var relativePath = '';
            for (var i = 1; i < pathSegments.length; i++) {
                relativePath += '../';
            }
            return relativePath;
        }
    }
</script>

<script src="https://js.paystack.co/v1/inline.js"></script>
