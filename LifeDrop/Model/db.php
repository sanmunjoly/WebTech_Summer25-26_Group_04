<?php

class db
{
    function connection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "bloodbridge_db";

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($connection->connect_error) {
            die("Please Connect the Database");
        }

        $connection->set_charset("utf8mb4");
        return $connection;
    }
}
