<?php
session_start();
include("connect.php");

$message = $_POST['message'];
$groupid = $_GET['groupid'];
$name = $_GET['name'];
$username = $_SESSION['username'];
$timesent = date('Y-m-d H:i:s');
$sql="INSERT INTO discussionmessage (messageText, groupid, discussionName, user, timeSent) VALUES ('$message', '$groupid', '$name', '$username', '$timesent')";
mysqli_query($conn, $sql);
$webname = "'discussion.php?groupid=" . $groupid . "&name=" . $name . "'";
echo "<script> location.href=".$webname."; </script>"
?>