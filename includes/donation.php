<script src="https://js.paystack.co/v1/inline.js"></script>

<?php
include 'configs.php';

$currency = "KES";
?>

<script type="text/javascript">
    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
        let donorName = document.getElementById('donorName').value;
        sessionStorage.setItem('donorName', donorName);
        e.preventDefault();
        let handler = PaystackPop.setup({
            key: '<?php echo $PublicKey; ?>',
            email: document.getElementById('donorEmail').value, // Get email from form
            amount: document.getElementById('donorAmount').value * 100, // Get amount from form
            currency: '<?php echo $currency; ?>',
            ref: '' + Math.floor((Math.random() * 1000000000) + 1),
            onClose: function() {
                alert('Transaction was not completed, window closed.');

            },
            callback: function(response) {
                let message = 'Payment complete! Reference: ' + response.reference;
                alert(message);
                window.location.href = "./includes/verify_transaction.php?reference=" + response.reference;
            }
        });
        

        handler.openIframe();
    }
</script>


<script src="https://js.paystack.co/v1/inline.js"></script>