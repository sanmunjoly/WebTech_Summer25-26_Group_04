<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = trim($_POST["email"] ?? "");
        $password = trim($_POST["password"] ?? "");

        if ($email == "" || $password == "") {
            echo "<p style='color:red;'>Email and password are required.</p>";
        }
        else {
            echo "<p style='color:green;'>Login information received successfully!</p>";
        }
    }

    ?>