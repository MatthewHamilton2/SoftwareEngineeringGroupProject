<?php
    include("connect.php");

    $messageid = filter_input(INPUT_POST, "messageid", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql="DELETE FROM discussionmessage WHERE messageid = $messageid";
    mysqli_query($conn, $sql);
?>