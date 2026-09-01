
<?php
include "db.php";
session_start();

$role="";
$name="";
$email="";
$phone="";
$blood="";
$location="";
$password="";
$confirm="";
$terms=false;
$message="";
$valid=true;

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $role=trim($_POST["role"]??"");
    $name=trim($_POST["name"]??"");
    $email=trim($_POST["email"]??"");
    $phone=trim($_POST["phone"]??"");
    $blood=trim($_POST["blood"]??"");
    $location=trim($_POST["location"]??"");
    $password=$_POST["password"]??"";
    $confirm=$_POST["confirm"]??"";
    $terms=isset($_POST["terms"]);

    if(empty($role))
    {
        $message="Please select your role.";
        $valid=false;
    }

    if(empty($name))
    {
        $message="Name is required.";
        $valid=false;
    }

    if(empty($email))
    {
        $message="Email is required.";
        $valid=false;
    }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $message="Enter a valid email.";
        $valid=false;
    }

    if(empty($phone) || !preg_match("/^[0-9]{11}$/",$phone))
    {
        $message="Invalid phone number. Enter exactly 11 digits.";
        $valid=false;
    }

    if(empty($blood))
    {
        $message="Please select your blood group.";
        $valid=false;
    }

    if(empty($location))
    {
        $message="Location is required.";
        $valid=false;
    }

    if(empty($password) || strlen($password)<6)
    {
        $message="Password must contain at least 6 characters.";
        $valid=false;
    }

    if(empty($confirm))
    {
        $message="Please confirm your password.";
        $valid=false;
    }
    elseif($password!=$confirm)
    {
        $message="Passwords do not match.";
        $valid=false;
    }

    if(!$terms)
    {
        $message="You must agree to the Terms & Conditions.";
        $valid=false;
    }

    if($valid)
    {
        if($role=="Donor")
        {
            $role="donor";
        }
        elseif($role=="Patient")
        {
            $role="patient";
        }
        elseif($role=="Admin")
        {
            $role="admin";
        }

        $database=new db();
        $connection=$database->connection();

        $result=$database->signup($connection,"users",$name,$email,$password,$phone,$location,$blood,$role);

        if($result)
        {
            $user_id=$connection->insert_id;

            $_SESSION["user_id"]=$user_id;
            $_SESSION["user_name"]=$name;
            $_SESSION["user_email"]=$email;
            $_SESSION["user_role"]=$role;

            if($role=="patient")
            {
                $sql="INSERT INTO recipient_profile(user_id) VALUES ('".$user_id."')";
                $connection->query($sql);
            }

            if($role=="donor")
            {
                $sql="INSERT INTO donor_profile(user_id) VALUES ('".$user_id."')";
                $connection->query($sql);
            }

            if($role=="admin")
            {
                header("Location: admin.php");
                exit();
            }
            elseif($role=="donor")
            {
                header("Location: donor.php");
                exit();
            }
            elseif($role=="patient")
            {
                header("Location: patient.php");
                exit();
            }
        }
    }
    else
    {
        echo $message;
    }
}
?>

