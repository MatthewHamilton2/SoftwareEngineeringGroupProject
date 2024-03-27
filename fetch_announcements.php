<?php
include("connect.php");

$lastTimestamp = $_GET['lastTimestamp'];
$groupid = $_GET['groupid'];

$sql = "SELECT * FROM announcements WHERE timeSent > '$lastTimestamp' AND groupid = '$groupid' ORDER BY timeSent ASC";
$result = mysqli_query($conn, $sql);
$newMessages = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $newMessages[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($newMessages);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error fetching new announcements']);
}
?>
