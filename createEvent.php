<?php
    include("connect.php");
    $eventname = filter_input(INPUT_POST, "eventname", FILTER_SANITIZE_SPECIAL_CHARS);
    $maxparticipants = filter_input(INPUT_POST, "maxparticipants", FILTER_SANITIZE_SPECIAL_CHARS);
    $starttime = filter_input(INPUT_POST, "starttime", FILTER_SANITIZE_SPECIAL_CHARS);
    $duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
    $groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);
    
    $sql = "INSERT INTO events (eventname, maxparticipants, participants, starttime, duration, organiser, descript, groupid) VALUES ('$eventname', '$maxparticipants', 1, '$starttime', '$duration', '$username', '$description', '$groupid')";
    mysqli_query($conn, $sql);

    $id = $conn->insert_id;

    $sql = "INSERT INTO events2users (eventid, username) VALUES ('$id', '$username')";
    mysqli_query($conn, $sql);
?>