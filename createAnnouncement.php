<?php
    session_start();
    include("connect.php");
    $text = filter_input(INPUT_POST, "announcementText", FILTER_SANITIZE_SPECIAL_CHARS);
    $groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO announcements (announcementtext, sender, groupid, timesent) VALUES ('$text', '$username', '$groupid', '$date')";
    mysqli_query($conn, $sql);
?>