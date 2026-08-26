<?php
$message="";
function updatePhone($phone){
    if($phone==""){
        return "Phone number is required.";
    }
    if(!preg_match("/^[0-9]{11}$/",$phone)){
        return "Invalid phone number. Enter exactly 11 digits.";
    }
    return "Phone number updated successfully.";
}
function updateLocation($location){
    if($location==""){
        return "Location is required.";
    }
    return "Location updated successfully.";
}
function changePassword($oldPassword,$newPassword,$confirmPassword){
    if($oldPassword==""){
        return "Current password is required.";
    }
    if($newPassword==""){
        return "New password is required.";
    }
    if(strlen($newPassword)<6){
        return "New password must contain at least 6 characters.";
    }
    if($confirmPassword==""){
        return "Please confirm your new password.";
    }
    if($newPassword!=$confirmPassword){
        return "New passwords do not match.";
    }
    return "Password changed successfully.";
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["update_phone"])){
        $phone=trim($_POST["phone"]??"");
        $message=updatePhone($phone);
        if($message=="Phone number updated successfully."){
        }
    }
    elseif(isset($_POST["update_location"])){
        $location=trim($_POST["location"]??"");
        $message=updateLocation($location);
        if($message=="Location updated successfully."){
        }
    }
    elseif(isset($_POST["change_password"])){
        $oldPassword=trim($_POST["oldPassword"]??"");
        $newPassword=trim($_POST["newPassword"]??"");
        $confirmPassword=trim($_POST["confirmPassword"]??"");
        $message=changePassword($oldPassword,$newPassword,$confirmPassword);
        if($message=="Password changed successfully."){
        }
    }
}
if($message!=""){
    echo "<p style='color:$messageColor; font-weight:bold; text-align:center;'>$message</p>";
}
?>