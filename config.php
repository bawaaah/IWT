<?php

    $connection = new mysqli("localhost", "root", "root", "service");

    if(mysqli_connect_errno()){
        echo "Error " . mysqli_connect_error();
    }
    else{
        // echo "Connected";
    }

?>