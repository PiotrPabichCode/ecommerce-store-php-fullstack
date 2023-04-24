<?php

    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "bibliopolium";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection->connect_errno != 0) {
        echo "Error: " . $connection->connect_errno;
    }

?>