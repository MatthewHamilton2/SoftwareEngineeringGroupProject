<?php
    include("connect.php");

    $eventid = filter_input(INPUT_POST, "eventid", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "INSERT INTO events2users (eventid, username) VALUES ('$eventid', '$username')";
    mysqli_query($conn, $sql);
?>