<?php
include "db.php";
session_start();

$password="";
$email="";
$valid=true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        $valid=false;
    }
    else if (strlen($password) < 6) {
        echo "Password must be at least 6 characters.";
        $valid=false;
    }

    if($valid)
    {
        $database = new db();
        $connection = $database->connection();

        $result=$database->signin($connection,"users",$email,$password);

        if($result!==false && $result->num_rows == 1)
        {
            $row=$result->fetch_assoc();

            $_SESSION["logged_In"] = true;
            $_SESSION["email"] = $email;
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["full_name"];
            $_SESSION["user_role"] = $row["role"];

            header("Location: profile.php");
            exit();
        }
        else
        {
            echo "Invalid email or password.";
        }
    }
}
?>