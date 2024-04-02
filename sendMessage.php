<?php
session_start();
include("connect.php");

$message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS);
$groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$timesent = date('Y-m-d H:i:s');
$sql="INSERT INTO message (messageText, groupid, user, timeSent) VALUES ('$message', '$groupid', '$username', '$timesent')";
mysqli_query($conn, $sql);
echo "<script> location.href='studentGroups.php"."?groupid=".$groupid."'; </script>"
?>