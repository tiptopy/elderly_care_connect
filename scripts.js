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

function togglePassword() {
  var passwordInput = document.getElementById("password");
  var toggleCheckbox = document.getElementById("show-password");
  var eyeIcon = document.querySelector(".password-toggle i");

  if (passwordInput.type === "password") {
      passwordInput.type = "text";
      eyeIcon.classList.add("fa-eye-slash");
      eyeIcon.classList.remove("fa-eye");
  } else {
      passwordInput.type = "password";
      eyeIcon.classList.add("fa-eye");
      eyeIcon.classList.remove("fa-eye-slash");
  }
  // Toggle checkbox state
  toggleCheckbox.checked = !toggleCheckbox.checked;
}