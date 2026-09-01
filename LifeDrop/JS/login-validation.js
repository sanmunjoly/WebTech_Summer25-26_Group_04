document.getElementById("loginForm").addEventListener("submit", function (event) {
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let valid = true;
    let message = "";

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        message += "Please enter a valid email address.\n";
        valid = false;
    }
    if (password.length < 4) {
        message += "Password must be at least 4 characters.\n";
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
        alert(message);
    }
});
