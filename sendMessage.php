<?php
session_start();
include("connect.php");

$message = $_POST['message'];
$groupid = $_GET['groupid'];
$username = $_SESSION['username'];
$timesent = date('Y-m-d H:i:s');
$sql="INSERT INTO message (messageText, groupid, user, timeSent) VALUES ('$message', '$groupid', '$username', '$timesent')";
mysqli_query($conn, $sql);
echo "<script> location.href='studentGroups.php"."?groupid=".$groupid."'; </script>"
?>