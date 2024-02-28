<?php
    session_start();
    include("connect.php");
    $text = filter_input(INPUT_POST, "announcementText", FILTER_SANITIZE_SPECIAL_CHARS);
    $user = $_SESSION["username"];
    $date = date('Y-m-d H:i:s');
    $groupid = $_GET["groupid"];
    $sql = "INSERT INTO announcements (announcementtext, sender, groupid, timesent) VALUES ('$text', '$user', '$groupid', '$date')";
    mysqli_query($conn, $sql);
    echo "<script> location.href='EducatorGroups.php"."?groupid=".$groupid."'; </script>";
?>