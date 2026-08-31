<?php
function validateRole($role){
if($role==""){
return "Please select your role.";
}
return "";
}
function validateName($name){
if($name==""){
return "Name is required.";
}
return "";
}
function validateEmail($email){
if($email==""){
return "Email is required.";
}
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
return "Enter a valid email.";
}
return "";
}
function validatePhone($phone){
if($phone==""){
return "Phone number is required.";
}
if(!preg_match("/^[0-9]{11}$/",$phone)){
return "Invalid phone number. Enter exactly 11 digits.";
}
return "";
}
function validateBlood($blood){
if($blood==""){
return "Please select your blood group.";
}
return "";
}
function validateLocation($location){
if($location==""){
return "Location is required.";
}
return "";
}
function validatePassword($password,$confirm){
if($password==""){
return "Password is required.";
}
if(strlen($password)<6){
return "Password must contain at least 6 characters.";
}
if($confirm==""){
return "Please confirm your password.";
}
if($password!=$confirm){
return "Passwords do not match.";
}
return "";
}
function validateTerms($terms){
if(!$terms){
return "You must agree to the Terms & Conditions.";
}
return "";
}
$message="";
$messageColor="red";
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["register"])){
$role=trim($_POST["role"]??"");
$name=trim($_POST["name"]??"");
$email=trim($_POST["email"]??"");
$phone=trim($_POST["phone"]??"");
$blood=trim($_POST["blood"]??"");
$location=trim($_POST["location"]??"");
$password=$_POST["password"]??"";
$confirm=$_POST["confirm"]??"";
$terms=isset($_POST["terms"]);
$message=validateRole($role);
if($message=="") $message=validateName($name);
if($message=="") $message=validateEmail($email);
if($message=="") $message=validatePhone($phone);
if($message=="") $message=validateBlood($blood);
if($message=="") $message=validateLocation($location);
if($message=="") $message=validatePassword($password,$confirm);
if($message=="") $message=validateTerms($terms);
if($message==""){
$message="Account created successfully!";
}
echo "<p style='color:$messageColor;font-weight:bold;text-align:center;'>$message</p>";
}
?>