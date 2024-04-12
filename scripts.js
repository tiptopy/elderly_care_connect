function toggleDonateForm() {
  var form = document.getElementById("paymentForm");
  if (form.style.display === "none") {
      form.style.display = "block";
  } else {
      form.style.display = "none";
  }
}

function validateDonationAmount() {
  var amount = document.getElementById("donorAmount").value;

  if (amount <=0 || amount.startsWith("-") || amount.startsWith(".")) {
      var popupMessage = document.getElementById("popupMessage");
      var popupText = document.getElementById("popupText");
      popupText.innerText = "Enter a valid Amount!";
      popupMessage.style.display = "block";
      return false;
  }
  return true;
}

function closePopup() {
  var popupMessage = document.getElementById("popupMessage");
  popupMessage.style.display = "none";
  donorAmount.value = "";
  document.getElementById("donorAmount").focus();
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

function confirmDelete() {
  if (confirm("Are you sure you want to delete this profile?")) {
      window.location.href = "delete_profile.php?id=' . $user_id . '";
  }
}