<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Email and password empty kina check
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    }
    // Valid email kina check
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    }
    else {
        // Any valid email and password will be accepted
        $_SESSION["admin"] = $email;

        // Remember admin login using cookie
        setcookie("bloodbridge_admin", $email, time() + 86400, "/");

        // Go to admin panel
        header("Location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BloodBridge Admin Login</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-box {
            width: 380px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #c62828;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #c62828;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #c62828;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #a91f1f;
        }

        .error {
            background: #ffe5e5;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .logo {
            text-align: center;
            font-size: 40px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <div class="logo"></div>

    <h2>BloodBridge</h2>

    <p class="subtitle">Admin Panel Login</p>

    <?php if (!empty($error)) { ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>Email Address</label>
        <input
            type="email"
            name="email"
            placeholder="Enter your Gmail"
            required
        >

        <label>Password</label>
        <input
            type="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <button type="submit">Login</button>

    </form>

</div>

</body>
</html>
