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
//function to sort transaction table
document.addEventListener("DOMContentLoaded", function () {
  const table = document.getElementById('transactionTable');
  const tbody = table.querySelector('tbody');
  const ths = table.querySelectorAll('thead th');

  ths.forEach(th => th.addEventListener('click', () => {
      const sortOrder = th.dataset.sortOrder === 'asc' ? -1 : 1;
      const index = th.cellIndex;

      const rows = Array.from(tbody.querySelectorAll('tr'));
      rows.sort((a, b) => {
          const aValue = a.children[index].textContent.trim();
          const bValue = b.children[index].textContent.trim();
          return sortOrder * aValue.localeCompare(bValue, undefined, {numeric: true});
      });

      tbody.innerHTML = '';
      rows.forEach(row => tbody.appendChild(row));
      th.dataset.sortOrder = th.dataset.sortOrder === 'asc' ? 'desc' : 'asc';
  }));
});