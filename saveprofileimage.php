<?php
    include("connect.php");
    session_start();

    $username = $_SESSION['username'];

    $sql = "INSERT INTO userimage (username, profileimage) VALUES ('$username', '$image')";

   mysqli_query($conn,$sql);
?>
