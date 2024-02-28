<?php
    session_start();
    include("connect.php");
    $discussionname = filter_input(INPUT_POST, "discussionName", FILTER_SANITIZE_SPECIAL_CHARS);
    $groupid = $_GET['groupid'];
    $sql = "INSERT INTO discussions (discussionName, groupid) VALUES ('$discussionname', '$groupid')";
    mysqli_query($conn, $sql);
    echo "<script> location.href='EducatorGroups.php"."?groupid=".$groupid."'; </script>";
?>