function toggleDonateForm() {
    const DonateForm = document.getElementById('paymentForm');
    DonateForm.style.display = DonateForm.style.display === 'none' ? 'block' : 'none';
  }
  
  function closeForm() {
    document.getElementById("paymentForm").style.display = "none";
}
function toggleMenu(){
  const menu = document.querySelector(".menu-links");
  const icon = document.querySelector(".humberger-icon");
  
  menu.classList.toggle("open");
  icon.classList.toggle("open");
}
