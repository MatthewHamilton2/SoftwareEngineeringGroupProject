<?php
    session_start();
    include("connect.php");
    $discussionname = filter_input(INPUT_POST, "discussionName", FILTER_SANITIZE_SPECIAL_CHARS);
    $groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql = "INSERT INTO discussions (discussionName, groupid) VALUES ('$discussionname', '$groupid')";
    mysqli_query($conn, $sql);
?>