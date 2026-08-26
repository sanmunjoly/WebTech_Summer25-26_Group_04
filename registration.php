<?php
include "registrationValidation.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Blood Bridge Registration</title>
<link rel="stylesheet" href="style.css">
<script>
function registerUser(){
let name=document.getElementById("name").value.trim();
let email=document.getElementById("email").value.trim();
let phone=document.getElementById("phone").value.trim();
let blood=document.getElementById("blood").value;
let location=document.getElementById("location").value.trim();
let password=document.getElementById("password").value;
let confirm=document.getElementById("confirm").value;
let role=document.getElementById("role").value;
let terms=document.getElementById("terms").checked;
let message="";
let valid=true;

if(role==""){
message+="Please select your role\n";
valid=false;
}
if(name==""){
message+="Name is required\n";
valid=false;
}
if(email==""){
message+="Email is required\n";
valid=false;
}
else if(!email.includes("@")){
message+="Enter a valid email\n";
valid=false;
}
if(phone==""){
    message+="Phone number is required\n";
    valid=false;
}
else if(!/^[0-9]{11}$/.test(phone)){
    message+="Phone number must contain exactly 11 digits\n";
    valid=false;
}

if(blood==""){
message+="Please select your blood group\n";
valid=false;
}
if(location==""){
message+="Location is required\n";
valid=false;
}
if(password==""){
message+="Password is required\n";
valid=false;
}
else if(password.length<6){
message+="Password must contain at least 6 characters\n";
valid=false;
}
if(confirm==""){
message+="Please confirm your password\n";
valid=false;
}
else if(password!=confirm){
message+="Passwords do not match\n";
valid=false;
}
if(!terms){
message+="You must agree to the Terms & Conditions\n";
valid=false;
}
if(!valid){
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
<h1>Create Account</h1>
<p>Join Blood Bridge and help save lives.</p>
<form id="registration" method="POST" onsubmit="return registerUser()">
<label>Register As</label>
<select id="role" name="role">
<option value="">Select Role</option>
<option value="Donor">Donor</option>
<option value="Patient">Patient</option>
<option value="Admin">Admin</option>
</select>
<label>Full Name</label>
<input type="text" id="name" name="name" placeholder="Enter your name">
<label>Email</label>
<input type="text" id="email" name="email" placeholder="Enter your email">
<label>Phone</label>
<input type="text" id="phone" name="phone" placeholder="Enter phone number">
<label>Blood Group</label>
<select id="blood" name="blood">
<option value="">Select Blood Group</option>
<option value="A+">A+</option>
<option value="A-">A-</option>
<option value="B+">B+</option>
<option value="B-">B-</option>
<option value="O+">O+</option>
<option value="O-">O-</option>
<option value="AB+">AB+</option>
<option value="AB-">AB-</option>
</select>
<label for="location">Location</label>
<input type="text" id="location" name="location" placeholder="Enter your location">
<label for="password">Password</label>
<input type="password" id="password" name="password" placeholder="Create password">
<label>Confirm Password</label>
<input type="password" id="confirm" name="confirm" placeholder="Confirm password">
<div class="terms">
<input type="checkbox" id="terms" name="terms">
<label for="terms">I agree to the Terms & Conditions</label>
</div>
<button type="submit" name="register">Create Account</button>
</form>
<p>Already have an account? <a href="login.php">Sign In</a></p>
</div>
</body>
</html>