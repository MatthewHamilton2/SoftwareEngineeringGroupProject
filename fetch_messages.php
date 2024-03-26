<?php
include("connect.php");

$lastTimestamp = $_GET['lastTimestamp'];
$discussion = $_GET['discussion'];
$groupid = $_GET['groupid'];

$sql = "SELECT * FROM discussionmessage WHERE timeSent > '$lastTimestamp' AND discussionName = '$discussion' AND groupid = '$groupid' ORDER BY timeSent ASC";
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
    echo json_encode(['error' => 'Error fetching new messages']);
}
?>
