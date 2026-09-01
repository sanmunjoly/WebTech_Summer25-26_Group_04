<?php
include "db.php";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $database=new db();
    $connection=$database->connection();

    if(isset($_POST["username"]))
    {
        $username=trim($_POST["username"]);

        if(empty($username))
        {
            echo "Username Required";
            exit();
        }

        $result=$database->CheckUser($connection,"users",$username);

        if($result->num_rows>0)
        {
            echo "User Name Taken";
        }
        else
        {
            echo "User Name Available";
        }
    }
    elseif(isset($_POST["email"]))
    {
        $email=trim($_POST["email"]);

        if(empty($email))
        {
            echo "Email Required";
            exit();
        }

        $result=$database->CheckEmail($connection,"users",$email);

        if($result->num_rows>0)
        {
            echo "Email Already Exists";
        }
        else
        {
            echo "Email Available";
        }
    }
}
?>
