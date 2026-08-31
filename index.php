<?php
 
include "config/database.php";
 
?>
 
<!DOCTYPE html>
<html>
 
<head>
 
<title>BloodBridge - Blood Donation Management System</title>
 
 
<style>
 
body

{

    margin:0;

    font-family:Arial, sans-serif;

    background:#f5f5f5;

}
 
 
/* Navigation Bar */
 
.navbar

{

    background:#b71c1c;

    padding:15px 40px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    color:white;

}
 
 
.logo

{

    font-size:28px;

    font-weight:bold;

}
 
 
.navbar a

{

    color:white;

    text-decoration:none;

    margin-left:20px;

    font-size:16px;

}
 
 
/* Hero Section */
 
.hero

{

    background:white;

    padding:60px;

    text-align:center;

}
 
 
.hero h1

{

    color:#b71c1c;

    font-size:42px;

}
 
 
.hero p

{

    font-size:20px;

    color:#555;

}
 
 
.btn

{

    display:inline-block;

    padding:12px 25px;

    margin:15px;

    background:#b71c1c;

    color:white;

    text-decoration:none;

    border-radius:5px;

}
 
 
/* Cards */
 
.container

{

    display:flex;

    justify-content:center;

    gap:30px;

    padding:40px;

}
 
 
.card

{

    background:white;

    width:280px;

    padding:25px;

    text-align:center;

    border-radius:10px;

    box-shadow:0px 0px 10px #ccc;

}
 
 
.card h2

{

    color:#b71c1c;

}
 
 
.footer

{

    background:#222;

    color:white;

    text-align:center;

    padding:15px;

}
 
 
</style>
 
 
</head>
 
 
<body>
 
 
<!-- Navigation -->
 
 
<div class="navbar">
 
 
<div class="logo">
 
BloodBridge
 
</div>
 
 
<div>
 
<a href="index.php">

Home
</a>
 
 
<a href="login.php">

Login
</a>
 
 
<a href="register.php">

Register
</a>
 
 
</div>
 
 
</div>
 
 
<!-- Hero Section -->
 
 
<div class="hero">
 
 
<h1>

Donate Blood, Save Lives
</h1>
 
 
<p>

A smart blood donation management system connecting donors and recipients quickly.
</p>
 
 
<a class="btn" href="register.php">

Become Donor
</a>
 
 
<a class="btn" href="login.php">

Find Blood
</a>
 
 
</div>
 
 
 
<!-- Features -->
 
 
<div class="container">
 
 
<div class="card">
 
<h2>

Donor
</h2>
 
<p>

Register as a donor, update availability, accept blood requests and track donation history.
</p>
 
 
</div>
 
 
<div class="card">
 
<h2>

Recipient
</h2>
 
<p>

Search available donors, request blood and track request status.
</p>
 
 
</div>
 
 
 
<div class="card">
 
<h2>

Admin
</h2>
 
<p>

Manage users, blood requests and blood stock information.
</p>
 
 
</div>
 
 
</div>
 
 
 
<div class="footer">
 
<p>

© 2026 BloodBridge | Blood Donation Management System
</p>
 
</div>
 
 
</body>
 
</html>
 