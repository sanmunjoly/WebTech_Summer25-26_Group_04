<?php
class db{
function connection(){
$db_host="localhost";
$db_user="root";
$db_password="";
$db_name="bloodbridge_db";

$connection=new mysqli($db_host,$db_user,$db_password,$db_name);

if($connection->connect_error){
die("Please Connect the Database");
}

return $connection;
}
function signup($connection,$tablename,$name,$email,$password,$phone,$location,$blood,$role){
$sql="INSERT INTO ".$tablename."(full_name,email,password,phone,blood_group,role,location) VALUES ('".$name."','".$email."','".$password."','".$phone."','".$blood."','".$role."','".$location."')";
$result=$connection->query($sql);
return $result;
}

function signin($connection,$tablename,$email,$password){
$sql="SELECT * FROM ".$tablename." WHERE email='".$email."' AND password='".$password."'";
$result=$connection->query($sql);
return $result;
}

function CheckUser($connection,$tablename,$username){
$sql="SELECT * FROM ".$tablename." WHERE email='".$username."'";
$result=$connection->query($sql);
return $result;
}

function CheckEmail($connection,$tablename,$email){
$sql="SELECT * FROM ".$tablename." WHERE email='".$email."'";
$result=$connection->query($sql);
return $result;
}
}
?>