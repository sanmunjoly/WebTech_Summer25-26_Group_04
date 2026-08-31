<?php
 
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "bloodbridge_db"
);
 
 
if(!$conn)
{
    die("Database Connection Failed: ".mysqli_connect_error());
}
 
?>