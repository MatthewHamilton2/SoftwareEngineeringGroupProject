<?php
include("connect.php");
    $lastTimestamp = $_GET['lastTimestamp'];
	$groupid = $_GET['groupid'];
	

    $sql = "SELECT * FROM message WHERE timeSent > '$lastTimestamp' AND groupid = '$groupid' ORDER BY timeSent ASC";
    $result = mysqli_query($conn, $sql);
    $newMessages = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $newMessages[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($newMessages);
?>
