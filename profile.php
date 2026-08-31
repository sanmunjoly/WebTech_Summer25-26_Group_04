<?php
include "profilevalidation.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Blood Bridge Profile</title>
<link rel="stylesheet" href="style.css">
<script>
function update_Phone() {
    let phone = document.getElementById("phone").value.trim();
    if (phone == "") {
        alert("Please enter your phone number");
        return false;
    }
    return true;
}
function update_location() {
    let location = document.getElementById("location").value.trim();
    if (location == "") {
        alert("Please enter your location");
        return false;
    }
    return true;
}
function changePassword() {
    let oldPassword = document.getElementById("oldPassword").value;
    let newPassword = document.getElementById("newPassword").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    if (oldPassword == "") {
        alert("Please enter your current password");
        return false;
}
    if (newPassword == "") {
        alert("Please enter a new password");
        return false;
    }
    if (newPassword.length < 6) {
        alert("New password must contain at least 6 characters");
        return false;
    }
    if (confirmPassword == "") {
        alert("Please confirm your new password");
        return false;
    }
    if (newPassword != confirmPassword) {
        alert("New passwords do not match");
        return false;
    }
    return true;
}
</script>
</head>
<body>
<main>
<h2>🩸 Blood Bridge</h2>
<h1>My Profile</h1>
<p>Manage your account information</p>
<h2>Account Information</h2>
<p><b>Register As:</b> Donor</p>
<p><b>Full Name:</b> Liyan</p>
<p><b>Email:</b> liyan@gmail.com</p>
<p><b>Blood Group:</b> O+</p>
<p>
<b>Phone:</b>
<span id="displayPhone">01712345678</span>
</p>
<p>
<b>Location:</b>
<span id="displayLocation">Dhaka</span>
</p>
<h2>Update Phone</h2>
<form method="POST" onsubmit="return update_Phone()">
    <label>Phone Number</label>
    <input type="text" id="phone" name="phone" placeholder="Enter new phone number" >
    <br><br>
    <input type="submit" name="update_phone" value="Update Phone" >
</form>
<h2>Update Location</h2>
<form method="POST" onsubmit="return update_location()">
    <label>Location</label>
    <input type="text" id="location" name="location" placeholder="Enter new location">
    <br><br>
    <input type="submit" name="update_location value="Update Location" >
</form>
<h2>Change Password</h2>
<form method="POST" onsubmit="return changePassword()">
    <label>Current Password</label>
    <input type="password" id="oldPassword" name="oldPassword" placeholder="Enter current password">
    <br><br>
    <label>New Password</label>
    <input type="password"  id="newPassword"name="newPassword" placeholder="Enter new password">
    <br><br>
    <label>Confirm New Password</label>
    <input type="password" id="confirmPassword" name="confirmPassword"  placeholder="Confirm new password" >
    <br><br>
    <input type="submit"name="change_password" value="Change Password" >
</form>
<br>
<a href="login.php">Logout</a>
</main>
</body>
</html>