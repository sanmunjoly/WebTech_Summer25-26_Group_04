<?php
include "loginvalidation.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blood Bridge Login</title>
    <link rel="stylesheet" href="style.css">

    <script>
    function collect_data() {
        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("password").value.trim();
        let message = "";
        let valid = true;
        if (email == "") {
            message += "Email is required\n";
            valid = false;
        }
        else if (!email.includes("@")) {
            message += "Enter a valid email\n";
            valid = false;
        }
       if (password == "") {
            message += "Password is required\n";
            valid = false;
        }
         else if (password.length < 6) {
    message += "Password must be at least 6 characters\n";
    valid = false;
}
        if (!valid) {
            alert(message);
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<div class="card">
    <h2>🩸 Blood Bridge</h2>
    <h1>Welcome Back!</h1>
    <p>Sign in to access your account.</p>
    <form id="loginForm" method="POST" onsubmit="return collect_data()">
        <label>Email</label>
        <input type="text" id="email" name="email" placeholder="Enter your email">
        <label>Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password">
        <br><br>
        <button type="submit">Sign In</button>
    </form>
    <p>
        Don't have an account?
        <a href="registration.php">Sign Up</a>
    </p>
</div>
</body>
</html>