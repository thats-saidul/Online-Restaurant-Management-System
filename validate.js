function validateCustomerForm() {
  const fullname = document.getElementById("fullname").value.trim();
  const email = document.getElementById("email").value.trim();
  const phone = document.getElementById("phone").value.trim();
  const password = document.getElementById("password").value;
  const cpassword = document.getElementById("cpassword").value;

  const nameRegex = /^[a-zA-Z ]{3,}$/;
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const phoneRegex = /^[0-9]{11}$/;
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

  if (!nameRegex.test(fullname)) {
    alert("Full Name must be at least 3 characters long and contain only letters and spaces.");
    return false;
  }

  if (!emailRegex.test(email)) {
    alert("Enter a valid email address.");
    return false;
  }

  if (!phoneRegex.test(phone)) {
    alert("Phone must be exactly 11 digits.");
    return false;
  }

  if (!passwordRegex.test(password)) {
    alert("Password must be at least 8 characters long and include at least one letter, one number, and one special character.");
    return false;
  }

  if (password !== cpassword) {
    alert("Passwords do not match.");
    return false;
  }

  return true;
}

function validateRiderForm() {
  return validateCustomerForm(); 
}
