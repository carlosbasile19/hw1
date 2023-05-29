function validateForm() {
    let name = document.getElementById("name").value;
    let last_name = document.getElementById("last_name").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let confirm_password = document.getElementById("confirm_password").value;

   
    if (name == "" || last_name == "" || email == "" || password == "" || confirm_password == "") {
      alert("Please fill in all fields");
      return false;
    }

    if (password.length < 8 && confirm_password.length < 8) {
        alert("Password must be at least 8 characters long");
        return false;
    }

    let hasUpperCase = /[A-Z]/.test(password);
    let hasLowerCase = /[a-z]/.test(password);
    let hasNumber = /\d/.test(password);
    if (!hasUpperCase || !hasLowerCase || !hasNumber) {
        alert("Password must contain at least one uppercase letter, one lowercase letter, and one number");
        return false;
    }

    if( password !== confirm_password){
        alert("Passwords do not match");
        return false;
    }
  
    return true;
  }