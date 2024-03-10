<?php
session_start();
include("connect.php");
$message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS);
$groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);
$channel = filter_input(INPUT_POST, "channel", FILTER_SANITIZE_SPECIAL_CHARS);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

$timesent = date('Y-m-d H:i:s');
$sql="INSERT INTO discussionmessage (messageText, groupid, discussionName, user, timeSent) VALUES ('$message', '$groupid', '$channel', '$username', '$timesent')";
mysqli_query($conn, $sql);
?>