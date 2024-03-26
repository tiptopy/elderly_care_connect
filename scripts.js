function toggleDonateForm() {
    const DonateForm = document.getElementById('paymentForm');
    DonateForm.style.display = DonateForm.style.display === 'none' ? 'block' : 'none';
  }
  
  function closeForm() {
    document.getElementById("paymentForm").style.display = "none";
}
