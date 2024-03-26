<?php
include("connect.php");
    $lastTimestamp = $_GET['lastTimestamp'];

    $sql = "SELECT * FROM message WHERE timeSent > '$lastTimestamp' ORDER BY timeSent ASC";
    $result = mysqli_query($conn, $sql);
    $newMessages = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $newMessages[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($newMessages);
?>
