<?php
    include("connect.php");
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "INSERT INTO educatorgroups2users (groupid, user) VALUES ('$groupid', '$username')";
    mysqli_query($conn, $sql);
?>